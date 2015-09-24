var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redisClient = new Redis({
  port: 6379,          // Redis port
  host: '46.101.195.171',   // Redis host
  family: 4,           // 4 (IPv4) or 6 (IPv6)
  password: 'Shipper@242423',
  db: 0
});

server.listen(1715);
io.on('connection', function (socket) {

	redisClient.psubscribe('*');

	redisClient.on("pmessage", function(subscribed, channel, message) {
		console.log(message);
	    message = JSON.parse(message);
	    socket.emit(channel + ':' + message.event, message.data);
	});
 
});
 