<?php

namespace App\Command;

use App\Service\PlayerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * php bin/console app:sendNotification
 *
 * Class SendNotificationCommand
 * @package App\Command
 */
class SendNotificationCommand extends Command
{
    protected static $defaultName = 'app:sendNotification';

    /**
     * @param PlayerService $playerService
     */
    public function __construct() {

        parent::__construct();
    }

    /**
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['NOTIFICATIONS', '============']);

        $start = microtime(true);

        $message = "test".date("Y-m-d H:i:s");
        $id = "x";
        $this->sendGCM($message, $id);



        $output->writeln([

        ]);

        $end = microtime(true);
        $diff = $end-$start;
        $output->writeln([
            'TIME: ' . \App\Helper\GeneralUtils::udate('i:s.u', $diff)
        ]);

        return 0;
    }

    function sendGCM($message, $id)
    {
        //$key = "AIzaSyAAlnnyKynsyj2OJipv5-86wFMHUDP_POg";
        //$key = "b83e5073a331312b3c5b4fde5d4dffe763b04ba9";
        $key = "AIzaSyAFKyb81a2d5HFd0v6xqnL3AWRt118ky_Q";

        //$key = "AIzaSyBt7tiddH0UTtcZe1QEdAgmEM7GA4VZGvQ";
        //$appKey = "1:9011990144:web:3b50902fec4f91b9526065";

        $appKey = "AAAAAhkoDoA:APA91bH1hJfmnZGvJG73rkGkHHeZQebAeJQ9s3gETzXzM0V97Zsm9tDe0RaS_dLs6kSbGusGpaAFWzUjXZDv1gFBTBmswrm-2t2d7-fc_nb0rNlNJwDD0ew5ri_75Bo9z0rCI8k_w-rf";

        $url = 'https://fcm.googleapis.com/fcm/send/'.$appKey;

        $fields = array (
            'registration_ids' => array (
                $id
            ),
            'data' => array (
                "message" => $message
            )
        );
        $fields = json_encode ( $fields );

        $headers = array (
            'Authorization: key=' . $key,
            'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        echo $result;
        curl_close ( $ch );
    }

}