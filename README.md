# Isfirequest
Simple Request Using PHP

## ✨ Examples

```php
require("Isfirequest.php");

$isfi = new Isfirequest;

// example default config
$isfi->config([
	"base_url" => "https://dummyapi.io/data/v1/",
	"headers" => [
		"app-id" => "0JyYiOQXQQr5H9OEn21312",
		"Content-Type" => "application/json"
	]
]);


// example post request
$data = [
	"firstName" => "Jamess",
	"lastName" => "Bond",
	"email" => "jamessbond@gmail.com"
];
$isfi->isfireq->post("user/create", $data)->json();


// example post request
$isfi->isfireq->get("user/637e8a8738790365ef08cc4e")->json();


// example add new header
$isfi->addHeaders([
	"Accept" => "application/json",
	"X-Requested-With" => "XMLHttpRequest",
	"User-Agent" => "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.125 Safari/537.36"
]);
```


## Author

👤 **Isfidev**

- Twitter: [@isfidev](https://twitter.com/isfidev)
- Github: [@isfidev9](https://github.com/isfidev9)

## Show your support

Please ⭐️ this repository if this project helped you!
