### Git para almundo.com


- Notas de interes

// Como no voy a realizar un test que supere más de 2h de mi tiempo de trabajo, ya que simplemente es un test laboral y no un trabajo, comento a relatar qué hubiera hecho si hubiese desarrollado ésto como un trabajo:

1. Desarrollo del RestAPI en NodeJS post consumo a través de AngularJS
1. 1. Estructura básica, implementación de lectura de info en base a JSON, respuestas, errores, sentences específicas para preguntas
1. 2. Acondicionar API solamente para respuesta de listado de hoteles puntuales en base a lo que se esté buscando (en éste ejemplo hubiera habilitado el buscador solamente para place: "AL mundo")
1. 3. MongoDB: estructura & performance -escalabilidad-
1. 4. NodeJS: express
1. 5. NPM: acondicionamiento
1. 6. AngularJS: SCRUM autónomo para verificar estructuras previas y empezar desarrollo post implementación
2. AngularJS
2. 1. myApp: Hoteles. [ngResource, ngProgress, ngAnimate, 'toaster']. CFG, etcétera.
2. 2. filters, factory, directives, functiones, scopes específicos para el listado (el listado lo obtengo exteriormente -SEGURIDAD!!!- y no como está actualmente -INSEGURO!!!!-)
2. 3. read en base a schema: name|details|price|available|offers, etcétera
3. cooking on: APP testing
4. finalizo SCRUM con test users y auto-puteandome como si fuera el project manager
5. Testing de seguridad: hacking a directorios -backend, etc-
6. Listo?


// Como espero que puedan apreciar, el test que pidieron es complejo, y mucho tiempo para desarrollar. Lo hice lo más rápido y similar a lo que pedían, aunque sabemos bien que el objecto que les cree para leer los hoteles no es ni cerca lo que buscaban. Espero sepan entender que estaban pidiendo demasiado para el tiempo que debería durar un test.



// Firma: MR. Web development, ecommerce. mail-to: maximiliano.rodriguez@uns.edu.ar
