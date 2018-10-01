# DEPRECATED

This api is deprecated.

shutterstock-php-client
=============

See exmaple.php file for usage examples
Be sure to run composer autoload

     composer.phar dump-autoload -o

* API Client classes
* api-client : initialization, auth, test, subscriptions, lightboxes
* images : id, search, categories, similar, recommendations, subscriptions(download), download history
* lightboxes : id, extended, images, public_url
* videos : id, search, download history

Example

//REST Client

    $presto = new Presto\Presto();

//Response processor

    $response = new Shutterstock\Response();

// Create API instance, pass in REST client and Response processor

    $api = new Shutterstock\Api('[api username]','[api key]', $presto, $response);

// Authenticate a user, will return a token for user on additional calls

    $api->authUser('[username]','[password]');

// Set username and token to use for API calls

    $api->setUser('['username]', '[auth token]');
