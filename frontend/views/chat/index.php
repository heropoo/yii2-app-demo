<?php

/** @var \common\models\User $user */

?><div id="msg-box" style="border: 1px solid #ccc;height: 600px;width: 460px;padding: 10px"></div>
<div style="margin-top: 5px">
    <input type="text" id="msg-input" class="form-control pull-left" style="width: 400px;">
    <button class="btn btn-primary pull-left" style="margin-left: 7px" onclick="send_msg()">发送</button>
</div>
<script>
    let ws;
    let cid;
    window.onload = function(){
        ws = new WebSocket("ws://localhost:2346/?key=<?= $user->getAuthKey()?>");
        ws.onopen = function(){
            //ws.send('请求连接。。。');
            write_msg('请求连接。。。', 1);
        };

        ws.onmessage = function(evt){
            let received_msg = JSON.parse(evt.data);
            if(typeof received_msg.cid != "undefined"){
                cid = received_msg.cid;
            }
            write_msg(received_msg.msg, received_msg.type, received_msg.id);
        };

        ws.onclose = function(){
            console.log('连接已关闭。。。');
            write_msg('连接已关闭。。。', 1);
        };
    };

    function write_msg(msg, type, id) {
        if(type == 1){
            msg = '<div class="msg" style="color: blue">'+ msg+'</div>';
        }else if(type == 2) {
            msg = '<div class="msg" style="color: #333;text-align: right">'+ msg+'</div>';
        }else if(type == 3){
            msg = '<div class="msg" style="color: #333;text-align: left">'+ msg+'</div>';
        }
        document.getElementById('msg-box').innerHTML += msg;
    }

    function send_msg(){
        let msg_input = document.getElementById('msg-input');
        console.log(msg_input.value);
        if(msg_input.value.length == 0){
            msg_input.focus();
            return false;
        }
        ws.send(msg_input.value);
        msg_input.value = '';
    }
</script>