<script>
var localStorage = window.localStorage;

localStorage.setItem('y','20');

console.log('Length: ' + localStorage.length);
console.log('Get item- y : '+ localStorage.getItem('y'));
console.log('Get item via key: ' + localStorage.key(0));

localStorage.removeItem('y');

console.log(localStorage.getItem('y') === null);

localStorage.clear();

console.log('Length: ' + localStorage.length);

console.log(typeof window.localStorage); // to check if it exists
console.log(typeof window.sessionStorage); // to check if it exists

/*

Local Storage

* Local Storage is limited to 5MB across all major browsers.

Session Storage

*  For sessionStorage, it's window.sessionStorage.
*  Lasts longer only till the window tab is open and gets destroyed otherwise
*  API methods remain the same as Local Storage

*/

</script>
