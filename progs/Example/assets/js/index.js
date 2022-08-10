import _ from 'lodash';

function component2() {
    const element = document.createElement('div');
  
    // Lodash, currently included via a script, is required for this line to work
    element.innerHTML = _.join(['Hello', 'example'], ' ');
  
    return element;
}
  
document.body.appendChild(component2());