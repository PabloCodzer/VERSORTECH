# VERSORTECH

Criado repositório com front e api de forma separados;
API: Conforme especificado, basta rodar o comando "php -S localhost:7070"; 
FRONT: Front usa o mesmo comando, ex: "php -S localhost:8001";

A API comunica Usando JSON, e foi adicionado CORS no header. Cada rota  utiliza um controller especifico. 
O front, usa datatables, e comunica com a api usando a bibliotecha axios. Os dados para crud, são passados
através do body( no caso do axios, o data);

Próximas espanções: Identificação por API_KEY e validação auth;

A versãodo php neste projeto é a 8;
e para controle das dos acessos, foi utilizado .htacess. 
