<?php
    session_start();
    include("config.php");
    
    //Connection Test==============================================>
        // Check connection
        /*if ($db->connect_error) {
            die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
        }
        echo "Connected successfully";*/
    //end of Connection Test============================================>

    $conversationid = mysqli_real_escape_string($db,$_GET['cid']);
    $requestinguser = mysqli_real_escape_string($db,$_GET['requser']);

    $messages = "";
    $found = false;

    $sql = "SELECT * FROM user_conversation_messages WHERE conversation_id = $conversationid";

    if($result = mysqli_query($db, $sql)) {
        while($row = mysqli_fetch_assoc($result)) {
            $found = true;
            //`message_id`, `conversation_id`, `message`, `sender`, `receiver`, `send_date`, `message_read`, `message_deleted`
            $msgid = $row["message_id"];
            $msg_message = $row["message"];
            $msg_sender = $row["sender"];
            $msg_receiver = $row["receiver"];
            $msg_senddate = $row["send_date"];
            $msg_read = $row["message_read"];
            $msg_deleted = $row["message_deleted"];

            $readStausIcon = "";

            if($msg_read == 1){
                $readStausIcon = '<i class="fas fa-check-double"></i>';
            }else{
                $readStausIcon = '<i class="fas fa-check"></i>';
            }

            if($msg_sender == $requestinguser){
                $messages .= '
                <div class="container bubble-right my-4 py-4 shadow" id="message-'.$conversationid.'-'.$msgid.'">
                    <div class="row align-items-end">
                        <div class="col-10 border-right border-white">
                            <p class="d-block text-wrap">'.$msg_message.'</p>
                            <div class="d-block text-right">
                                <div class="d-inline">'.$msg_senddate.'</div>
                                <div class="d-inline" style="color: #ffa500">'.$readStausIcon.'</div>
                            </div>
                        </div>
                        <div class="col-2 px-1 text-center">
                            <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" alt="profile thumbnail">
                        </div>
                    </div>
                </div>
                ';
            }else{
                $messages .= '
                <div class="container bubble-left my-4 py-4 shadow" id="message-'.$conversationid.'-'.$msgid.'">
                    <div class="row align-items-end">
                        <div class="col-2 px-1 text-center">
                            <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" alt="profile thumbnail">
                        </div>
                        <div class="col-10 border-left border-white">
                            <p class="d-block text-wrap">'.$msg_message.'</p>
                            <div class="d-block text-left">
                                <div class="d-inline">'.$msg_senddate.'</div>
                                <div class="d-inline" style="color: #ffa500">'.$readStausIcon.'</div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            
        }

        if($found == true){
            echo $messages;
        }else{
            echo "No messages. Send a message to get the conversation going.";
        }
    }else{
        $output .= "|[System Error]|:. [Messenger (load conversation) - ".mysqli_error($db)."]";
        echo $output;
    }
