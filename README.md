# sky-api-tutorial-auth-code-php

Blackbaud SKY API Authorization Code Flow demo application.

## About

The Blackbaud SKY API currently supports the [Authorization Code Flow](https://apidocs.sky.blackbaud.com/docs/authorization/), which requires a back-end server component to securely store the client secret.  For this code sample, we've implemented the server component using PHP.

We've stripped down the user interface to highlight the Authorization Code Flow.  Our [Barkbaud code samples](https://apidocs.sky.blackbaud.com/docs/code/) provide a rich user interface using [SKY UX](http://skyux.developer.blackbaud.com/).

Feel free to leave feedback by filing an [issue](https://github.com/blackbaud/sky-api-auth-tutorial/issues).

## Requirements

A local running Apache server to run and host the project.  For this example we recommend you install and run the project using [MAMP](https://www.mamp.info/en/).

To run this application in your environment, follow the [Auth Code Flow Tutorial](https://apidocs.sky.blackbaud.com/docs/code/auth-code-flow/) instructions within our documentation. 

> PHP sample coming soon.   Follow the instructions for obtaining the necessary keys from the other code samples.

## Getting Started

    1. Clone the repo.
    2. Copy the `config.php.sample` file to `config.php`.   Fill in the keys obtained from your Developer Account and registered application.
    3. Run MAMP.
    4. MAMP `Preferences` ->  `Web Server` -> Set the `Document Root` to point to the location of your cloned project.
    5. MAMP `Start Servers`.
    6. Open your browser to `http://localhost:8888`.



