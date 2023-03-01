

// environment.js
const HOST = '192.168.1.7'

// make sure to export the variable so you can import it in other files
export const HOST_WITH_PORT = 'http://${HOST}:3000`;
// ExampleScreen.js
import { HOST_WITH_PORT } from '../environment';
// ...
const onButtonSubmit = () => {
  fetch(`${HOST_WITH_PORT}/examples/example`, {
    method: 'POST',
    headers: {...}
  }
}