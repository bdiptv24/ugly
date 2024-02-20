// getM3U8.js
const axios = require('axios');

const channelId = process.argv[2]; // You can pass the channel ID as a command-line argument

// Your cookie value
const cookie = 'Edge-Cache-Cookie=URLPrefix=aHR0cHM6Ly9saXZlLWNkbi50c3BvcnRzLmNvbS8:Expires=1708504077:KeyName=tsports-ed25519-01:Signature=-na1Ohj9p5fsgo_6DeLuXKTHwBsKNljwqhIfGx5TvRri7xqxPiIP4QVFo-Dbdi6u2ZzKjrnR6w0GX25kLq23CQ';

const originalM3U8Link = `https://live-cdn.tsports.com/live-${channelId}/index.m3u8`;

axios.get(originalM3U8Link, {
  headers: {
    'Cookie': cookie
  }
})
.then(response => {
  console.log(response.data);
})
.catch(error => {
  console.error('Error fetching M3U8:', error.message);
});
