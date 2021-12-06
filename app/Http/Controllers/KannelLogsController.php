<?php

namespace App\Http\Controllers;

use App\Jobs\KannelLogs as JobsKannelLogs;
use App\Models\Kannel;
use App\Models\KannelLogs;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use SimpleXMLElement;

class KannelLogsController extends Controller
{

    public function kannelsStatus()
    {
        $kannels = Kannel::where('status', 1)->get();
        $kannels_title = [];
        $kannels_connection = [];

        if (isset($kannels) && count($kannels) > 0) {
            foreach ($kannels as $kannel) {
                $kannel_connection = $this->getKannelDetails($kannel->url);

                array_push($kannels_title, $kannel->title);
                $kannels_connection[$kannel->title] = $kannel_connection;
            }
        }

        return view('kannel.status', compact('kannels_title', 'kannels_connection'));
    }

    public function logs(Request $request)
    {
        $date   = $request->date ?? date('Y-m-d');

        $logs = KannelLogs::whereDate('created_at', $date)->when(request('kannel_id'), function ($q) {
            return $q->where('kannel_id', request('kannel_id'));
        })->get();

        if (isset($request->kannel_id) && $request->kannel_id != null) {
            $kannel = Kannel::where('status', 1)->where('id', $request->kannel_id)->first();
            $kannel = isset($kannel) && $kannel != null ? $kannel : null;
        } else {
            $kannel = null;
        }

        $kannels = Kannel::where('status', 1)->get();

        return view('kannel.logs', compact('kannels', 'logs', 'kannel', 'date'));
    }

    public function sendKannelsLogs()
    {
        JobsKannelLogs::dispatch();

        \Session::flash('send_kannel_logs', 'Kannel connection logs sent successfully.');

        return redirect()->back();
    }

    public function sendKannelsConnectionDetailsMail()
    {
        $kannels = Kannel::where('status', 1)->get();
        $kannels_title = [];
        $emails_title = [];
        $kannels_connection = [];

        if (isset($kannels) && count($kannels) > 0) {
            foreach ($kannels as $kannel) {
                $excel_link = $kannel->excel_link;

                $kannel_connection = $this->getKannelDetails($kannel->url);
                $kannel_connection['excel_link'] = $excel_link;

                array_push($kannels_title, $kannel->title);
                $emails_title[$kannel->title] = $kannel->title . ' Bulk SMS report.';
                $kannels_connection[$kannel->title] = $kannel_connection;

                // if (date('H') != 16) {
                //save kannel logs
                $this->saveKanelLog($kannel, $kannel_connection);
                //   }
            }

            //send kannel emails
            $subject = 'Bulk Report';
            $this->KannelMail($subject, $kannels_title, $emails_title, $kannels_connection);
        }

        return true;
    }

    private function saveKanelLog($kannel, $kannel_connection)
    {
        date_default_timezone_set('Africa/Cairo');

        $kannel_log = new KannelLogs();
        $kannel_log->connection_name = $kannel_connection['connection_name'];
        $kannel_log->ip = $kannel_connection['ip'];
        $kannel_log->port = $kannel_connection['port'];
        $kannel_log->status = $kannel_connection['status'];
        $kannel_log->sent = $kannel_connection['sent'];
        $kannel_log->queued = $kannel_connection['queued'];
        $kannel_log->failed = $kannel_connection['failed'];
        $kannel_log->throughput = $kannel_connection['throughput'];
        $kannel->logs()->save($kannel_log);
    }

    private function getKannelDetails($kannel_url)
    {
        $response = Http::get($kannel_url); //create request
        $kannelConnectionXMLData = new SimpleXMLElement($response->getBody()->getContents()); //formate response as xnl

        $smsc = $kannelConnectionXMLData->smscs->smsc[0]; //get first smsc object from request
        $connection_name = 'admin-id'; //formate string to use it in getting data from smsc object

        $kannel_connection = [];
        $kannel_connection['connection_name'] = (string)$smsc->$connection_name; //get connection_name from smsc object
        $kannel_connection['ip'] = $this->getKannelServerData($smsc, 'ip'); //get ip from smsc object
        $kannel_connection['port'] = $this->getKannelServerData($smsc, 'port'); //get port from smsc object
        $kannel_connection['status'] = (string)$kannelConnectionXMLData->status; //get status from smsc object
        $kannel_connection['sent'] = (string)$smsc->sms->sent; //get sent messages from smsc object
        $kannel_connection['queued'] = (string)$smsc->queued; //get queued from smsc object
        $kannel_connection['failed'] = (string)$smsc->failed; //get failed from smsc object
        $kannel_connection['throughput'] = $this->getKannelThroughput($smsc); //get throughput from smsc object

        return $kannel_connection;
    }

    private function getKannelServerData($smsc, $target_string)
    {
        $smsc_name = (string)$smsc->name; //get name from smsc object which has the ip address and port number

        if ($target_string == "ip") {
            return $this->getTargetString($smsc_name, "SMPP:", ":"); //cut ip address from smsc_name using start and end positions
        } elseif ($target_string == "port") {
            $ip = $this->getTargetString($smsc_name, "SMPP:", ":"); //cut ip address from smsc_name using start and end positions
            return $this->getTargetString($smsc_name, "$ip:", "/"); //cut port number from smsc_name using ipaddress as a starting point and "/" as ending point
        }
    }

    private function getTargetString($original_string, $target_start_string, $target_end_string)
    {
        $target_position = strpos($original_string, $target_start_string) + strlen($target_start_string);

        if ($target_position != -1) {
            $target_string = substr($original_string, $target_position);
            $target_end_position = strpos($target_string, $target_end_string);
            $connection_string = substr($target_string, 0, $target_end_position);

            return $connection_string;
        }

        return ' ';
    }

    private function getKannelThroughput($smsc)
    {
        $smsc_throughput = (string)$smsc->sms->outbound;

        $throughput = ceil(explode(",", $smsc_throughput)[2]);

        return $throughput;
    }

    public function sendEmail($id)
    {
        $kannel_log = KannelLogs::where('id', $id)->first();
        $kannel_connection['connection_name'] = $kannel_log->connection_name;
        $kannel_connection['ip'] = $kannel_log->ip;
        $kannel_connection['port'] = $kannel_log->port;
        $kannel_connection['status'] = $kannel_log->status;
        $kannel_connection['sent'] = $kannel_log->sent;
        $kannel_connection['queued']  = $kannel_log->queued;
        $kannel_connection['failed'] = $kannel_log->failed;
        $kannel_connection['throughput'] = $kannel_log->throughput;
        $kannel_connection['excel_link'] = $kannel_log->kannel->excel_link;

        $subject = $kannel_log->kannel->title . ' Bulk For [' . $kannel_log->created_at . '].';
        $kannel_title = [$kannel_log->kannel->title];
        $emails_title[$kannel_log->kannel->title] = $kannel_log->kannel->title . ' Bulk SMS report For [' . $kannel_log->created_at . '].';
        $kannels_connection[$kannel_log->kannel->title] = $kannel_connection;
        $this->KannelMail($subject, $kannel_title, $emails_title, $kannels_connection);

        \Session::flash('send_kannel_logs', 'Kannel connection logs for ' . $kannel_log->created_at . ' sent successfully.');
        return redirect()->back();
    }

    private function KannelMail($subject, $kannels_title, $emails_title, $kannels_connection)
    {
        $body = view('emails.kannel_logs', compact('kannels_title', 'emails_title', 'kannels_connection'))->render();

        $emails = emails();

        \Mail::send([], [], function ($email) use ($emails, $subject, $body) {
            $email->from(env('MAIL_USERNAME'));
            $email->to($emails)->subject($subject);
            $email->setBody($body, 'text/html');
        });
    }
}
