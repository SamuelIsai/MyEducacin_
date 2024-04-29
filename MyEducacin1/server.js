const http = require('http');
const fs = require('fs');
const path = require('path');
const url = require('url');

const server = http.createServer((req, res) => {
  const { pathname } = url.parse(req.url, true);

  // Manejar la solicitud de la página de inicio
  if (req.method === 'GET' && pathname === '/') {
    const filePath = path.join(__dirname, 'templates', 'login.php');

    fs.readFile(filePath, 'utf8', (err, content) => {
      if (err) {
        res.writeHead(500, { 'Content-Type': 'text/plain' });
        res.end('Error interno del servidor');
        return;
      }

      res.writeHead(200, { 'Content-Type': 'text/html' });
      res.end(content);
    });
  } else if (req.method === 'POST' && pathname === '/guardar-monedas') {
    // Lógica para guardar monedas
    // ...

    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ success: true }));
  } else {
    res.writeHead(404, { 'Content-Type': 'text/plain' });
    res.end('Not Found');
  }
});

const port = 5000;
server.listen(port, () => {
  console.log(`Servidor iniciado en http://localhost:${port}`);
});
