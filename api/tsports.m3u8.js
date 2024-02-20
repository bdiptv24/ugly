// api/tsports.m3u8.js
module.exports = async (req, res) => {
  const channelId = req.query.id;

  // Your logic to dynamically set the cookie based on the channel ID
  const dynamicCookie = getDynamicCookie(channelId);

  // Generate the M3U8 content dynamically
  const m3u8Content = `
    #EXTM3U
    #EXTINF:-1, Channel 1
    https://live-cdn.tsports.com/live-${channelId}/index.m3u8
    #EXTINF:-1, Channel 2
    https://live-cdn.tsports.com/live-${channelId}/index.m3u8
    #EXTINF:-1, Channel 3
    https://live-cdn.tsports.com/live-${channelId}mindex.m3u8
    #EXT-X-ENDLIST
  `;

  // Set response headers, including the cookie
  res.setHeader('Content-Type', 'application/vnd.apple.mpegurl');
  res.setHeader('Access-Control-Allow-Origin', '*'); // Adjust as needed
  res.setHeader('Set-Cookie', `Edge-Cache-Cookie=${dynamicCookie}`);

  // Send M3U8 response
  res.end(m3u8Content);

  // Replace this function with your logic to dynamically set the cookie
  function getDynamicCookie(channelId) {
    // Your logic to dynamically set the cookie based on the channel ID
    // For example, fetching from a database or an API
    return 'Edge-Cache-Cookie=URLPrefix=aHR0cHM6Ly9saXZlLWNkbi50c3BvcnRzLmNvbS8:Expires=1708504077:KeyName=tsports-ed25519-01:Signature=-na1Ohj9p5fsgo_6DeLuXKTHwBsKNljwqhIfGx5TvRri7xqxPiIP4QVFo-Dbdi6u2ZzKjrnR6w0GX25kLq23CQ';
  }
};
