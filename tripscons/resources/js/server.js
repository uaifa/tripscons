// var fs = require('fs');
// var app = require('express')();
// var http = require('http').createServer(app);
// var io = require('socket.io')(http);
// var Redis = require('ioredis');
// var redis = require('redis');
// var axios = require('axios');
//
// var redisClient = redis.createClient();
// redisClient.subscribe('laravel_database_message');
//
// io.on('connection', function (socket) {
//     console.log("client connected");
//     redisClient.on("message", function (channel, payload) {
//         var eventData = JSON.parse(payload);
//         socket.emit(eventData.event, eventData.data);
//     });
//     socket.on('disconnect', function () {
//
//     });
//     socket.on('new-message', function (msg) {
//         axios.post('https://healmaker.wantechsolutions.com/api/chat/create-message', msg)
//             .then((res) => {
//                 socket.broadcast.emit('conversation-' + msg.conversation_id, res.data);
//                 socket.emit('conversation-' + msg.conversation_id, res.data);
//                 console.log('chat message sent');
//             })
//             .catch((err) => {
//                 console.log('error creating new message');
//             })
//     });
// });
//
// http.listen(3000, function () {
//     console.log('listening on *:3000');
// });
