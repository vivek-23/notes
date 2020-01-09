* Both local storage and session storage are client storage solutions. You would never handle 
  senstive data in it and always make a defensive mechanism to not completely rely on it on server side.

* **Difference:**  Session storage is browser tab based. Every individual tab opened in browser for the 
  **same domain** has it's own session storage. Localstorage is independent of tabs and is same across the entire
  domain. They persist even after you close the browser window.

* It **should be noted that** data stored in either localStorage or sessionStorage is specific to the protocol of the page.


> LocalStorage: https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage

> SessionStorage: https://developer.mozilla.org/en-US/docs/Web/API/Window/sessionStorage
