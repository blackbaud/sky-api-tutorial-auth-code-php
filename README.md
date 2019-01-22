# PHP Authorization Code Flow - SKY API

Blackbaud SKY API Authorization Code Flow demo application.

This code sample is a very basic example of how to interact with the Blackbaud OAuth 2.0 Service.  You are free to choose the client library and method that best suit your needs when creating production-level applications.

## About

The Blackbaud SKY API currently supports the [Authorization Code Flow](https://developer.blackbaud.com/skyapi/docs/authorization), which requires a back-end server component to securely store the client secret.  For this code sample, we've implemented the server component using PHP.

We've stripped down the user interface to highlight the Authorization Code Flow.  Our [Barkbaud code samples](https://developer.blackbaud.com/skyapi/docs/code) provide a rich user interface using [SKY UX](http://developer.blackbaud.com/skyux).

Feel free to leave feedback by filing an [issue](https://github.com/blackbaud/sky-api-auth-tutorial/issues).

## Requirements

A local running Apache server to run and host the project.  For this example we recommend you install and run the project using [MAMP](https://www.mamp.info/en/).

To run this application in your environment, follow the [Auth Code Flow Tutorial](https://developer.blackbaud.com/skyapi/docs/code/auth-flows/auth-code-flow) instructions within our documentation. 

> PHP sample coming soon.   Follow the instructions for obtaining the necessary keys from the other code samples.

## Getting Started

    1. Clone the repo.
    2. Copy the `config.php.sample` file to `config.php`.   Fill in the keys obtained from your Developer Account and registered application.
    3. Run MAMP.
    4. MAMP `Preferences` ->  `Web Server` -> Set the `Document Root` to point to the location of your cloned project.
    5. MAMP `Start Servers`.
    6. Open your browser to `http://localhost:8888`.

## Making PATCH requests in AngularJS

First, construct the request data object.

```
let patchData = {
  constituent_id: 280,
  first: 'Robert'
};
```

Then, pass the request into the request's `data` property as a JSON string.
```
$http({
  method: 'patch',
  url: '/api/constituents.php',
  data: `data=${JSON.stringify(patchData)}`,
  headers : {
    'Content-Type': 'application/x-www-form-urlencoded'
  }
}).then(res => {
  console.log(res.data.status); // success
});
```
