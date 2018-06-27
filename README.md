Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require "obtao/recombeebundle:dev-master"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles,
in the `app/AppKernel.php` file of your project:

This bundle rely on JMS serializer as dependency, so if you are not using it yet, you have to add it too.

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new \Obtao\RecombeeBundle\ObtaoRecombeeBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle() // only if you are not using it yet
        );

        // ...
    }

    // ...
}
```
Step 3: Config the Bundle
-------------------------

```yaml
// app/config.yml

obtao_recombee:
    recombee_database_name: "your-database-name"
    recombee_secret_token: "your-api-key"
```

Step 4: Usage
-------------------------

Below example of usage in symfony controller to create a user and related properties.

Bundle provide 2 custom model (for user and item), feel free to modify according your needs.

BatchBuilder helper will extract all properties of such item to guess the best type for recombee API (need to implements HasSkuInterface)


```php
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Obtao\RecombeeBundle as ObtaoRecombee;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // service to reach API
        $apiCaller = $this->get('obtao.recombee.api.caller');
        // Helper to build batch  of properties
        $batchBuilder = $this->get('obtao.recombee.batch.builder');

        // reset database first (be careful !) : expected response "ok"
        $reset = var_dump($apiCaller->sendToApi(new ObtaoRecombee\Model\ResetDatase()));
        
        // create a new User
        $user = new ObtaoRecombee\Model\User();
        $user->setSku(12345);
        $user->setNickName('JohnDoe');
        $user->setOriginCountry('FR');
        
        // use batch helper to build all properties for user above
        /** @var Batch $batch */
        $batch = $batchBuilder->buildBatchOfProperties($user, ObtaoRecombee\Model\AddUserProperty::class);
        
        // send batch of properties to API : expected response batch of "ok"
        var_dump($apiCaller->sendToApi($batch));
        
        // create user : expected response "ok"
        var_dump($apiCaller->sendToApi(new ObtaoRecombee\Model\SetUserValues($user)));

        die('that\'s all folks');
    }
}
```
