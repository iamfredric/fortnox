# Fortnox

This package is a wrapper for the Fortnox API.

### Requirements
php ^8.0
Fortnox developer account https://developer.fortnox.se/

### Installation
```
composer reqiure "iamfredric/fortnox"
```

### Configuration
```php
\Iamfredric\Fortnox\Fortnox::setClientCredentials(
    clientId: 'your-app-client-id',
    clientSecret: 'your-app-client-secret',
    redirectUrl: 'http://your-app-url/fortnox/callback',
    scope: 'your scopes separated by spaces' 
);
```

#### Authenticate user
```php
// Redirect user to Fortnox for authentication
$url = \Iamfredric\Fortnox\Fortnox::authUrl();

// In your response handler, when fortnox redirects user back to your app,
$response = \Iamfredric\Fortnox\Fortnox::verifyAuthCode($_GET['code']);
$response['access_token'];
$response['refresh_token'];
$response['scope'];
$response['expires_in'];
$response['token_type'];
```

#### Working with resources
Before you can use the resources, you need to authenticate the user.
```php
// You need to pass an object that implements \Iamfredric\Fortnox\Contracts\Authenticatable
// to the authenticateAs method. This object will be used to get the access token and refresh 
// your access token when it expires.
\Iamfredric\Fortnox\Fortnox::authenticateAs(new class implements \Iamfredric\Fortnox\Contracts\Authenticatable {
    public function getFortnoxAccessToken(): string
    {
        return 'your-access-token';
    }
 
    public function getFortnoxRefreshToken(): string
    {
        return 'your-refresh-token'; 
    }

    public function getFortnoxExpiresAt(): DateTime
    {
        return new DateTime('Expiration date for token');
    }

    public function onFortnoxUpdate($data): void
    {
        // Update your database with the new access token and refresh token
    }
});
```
##### Get all customers
```php
use \Iamfredric\Fortnox\Resources\Customer;

$customers = Customer::all()

foreach ($customers as $customer) {
    /**  @var $customer Customer */
}
```

##### Get a customer
```php
use \Iamfredric\Fortnox\Resources\Customer;

$customer = Customer::find(1);
```

##### Create a customer
```php
use \Iamfredric\Fortnox\Resources\Customer;

$customer = Customer::create([
    'Name' => 'Acme INC'
]);
```

##### Update a customer
```php
use \Iamfredric\Fortnox\Resources\Customer;

$customer = Customer::find(1);
// Or
$customer = new Customer([
    "CustomerNumber" => "1",
])

$customer->update([
    'Name' => 'Acme INC'; 
])
// Or
$customer->Name = 'Acme INC';
$customer->save();
```

##### Delete a customer
```php
use \Iamfredric\Fortnox\Resources\Customer;

$customer = Customer::find(1);

$customer->delete();
```

----

### Extending current package
```php
class Order extends \Iamfredric\Fortnox\Resources\Resource
{
    protected function getIdKey(): string
    {
        return 'DocumentNumber';
    }
}

Order::all();
$order = Order::find(1);
$order->update([]);
$order->save();
$order->delete();
```

## Testing

```bash
composer run test
composer run analyze
composer run sniff
```
## Contributing

# Contributing

Contributions are **welcome**.

## Procedure

Before filing an issue:

- Attempt to replicate the problem, to ensure that it wasn't a coincidental incident.
- Check to make sure your feature suggestion isn't already present within the project.
- Check the pull requests tab to ensure that the bug doesn't have a fix in progress.
- Check the pull requests tab to ensure that the feature isn't already in progress.

Before submitting a pull request:

- Check the codebase to ensure that your feature doesn't already exist.
- Check the pull requests to ensure that another person hasn't already submitted the feature or fix.

## Requirements

If the project maintainer has any additional requirements, you will find them listed here.

- **[PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)** - The easiest way to apply the conventions is to install [PHP Code Sniffer](https://pear.php.net/package/PHP_CodeSniffer).

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](https://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.

**Happy coding**!

## License

The MIT License (MIT).

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
