<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017012305372432",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAoMMU2E2u/3mAsloSmLJu/ml48lw4hGyvK5456bxB52Lep/43GL8BUbxz5Sa+eJ6Q2XyNMulgcYsANfsWSsbPlpK9zmdZ4nSw0/hb0jGjr7CMR+iW5KUBQNaoXaGaJ+9uW5VwXwmWoXGn1VLOswUkD1RbgZT5FdSqfJXhzdPygYWzBlUfUEHx0VqXa7WQh1FWz2aWmG92Nazk2VsN90Bfj1VgGD178KDvIz3np15xbQhm0F2XLzQzP5MLK7uUfW2gZroElLijF088QwTuo3KkJ8Mc3kTnsXzzJ6FMpAQZA0pO6rERbXPkNqLy06Ky8u0SR+He7nJcv7lGXpVfFDqZ5QIDAQABAoIBABEaL9GDEibjiilvI6NS+DPgjJlb7jdISKpfPtH60RgIkJ9WkA314/IKFlo+cOzsEYTRl0PfR/9MRk131LtHwzXFjqOyowFQYK9sMHiAB2XdZk8QE11noGaBb4/mbTvqYNclYrr5jijGqpArKwooddmbo9B5RLZp1WlDmK4I6jeVEnD2Kkvh7X1M8Jbh9xBr1KNmRuBT4DHFf9WQGELNpOJpov/klVrdm7pWZhX7vr5MJm79ZwVc6HuVejE7a3X4pJqws8Zo9OqnqueXtVzDMVqfFmvO0jVMdajgrQU7heP4i1xLR5MeCGZmc9ZXKAFdIwClK8Sr3qgZOohYIz5RUVECgYEA0pHIrS684A25kjzYC1ME7fc1fDMilOp3mQMuzB/bx2FjJsF4DA/foMPHVTrxFBw9SeGj0P1g/yQC7fgY2vPoN2dJEghw3XiRf50V0TN5RXNT4dwMm1djy7qazfBSw7PHIEDDl5WkbSKjKGwPixeGjDI2XXUYJrVFjWVFLyIoISMCgYEAw3JSwHxtFCR54fCk5xTC5bcJze0Oli5b3WwiDlRP5ZRfAVL3xMp369KuOKuD9NBR6nCRT2tm4+WWqHwhvqBt9nYRGHlOjYdd6xZXzO7/wTCsSp4nVXQky5S+BElWKD0185cH6v6Goj4xpTdv94RDQsBUiqjOQ/601nAJHaSmPVcCgYB2WbAD/qfz+mLZ2c7IFqJHqdFq/EasklgkLVDJNALQPmF/L/BsPyO+9Sr9MYK8fd7IvsTXOwKghLoMzIwTzFExiqDcPNhK8nA83KqdiaPYsChuYsLHMMgLgtdtdmzeSBZcf2ovsdDX8kbn+kyGLfPWqoY54w1u/CWaglfvVPBfJwKBgQCOBRbItCF3D4JZgcnx+I4e6kB/mJCO5KTwYtDkZLOh+YyHo8hTAWTewbrDhy5dyLqdhqqwcTTUyVIOoBTNNjpxax3FEPDZutGuMBAg5FKICVxI5F9kov7RyAXDi57FoqT/mnGwer9OSa89hOkhjMRrTuKf10X69qxlXgfhuHDsBQKBgQCOdxZFveoSmhs0jrtovdgFy4zjdmnLjoNHSxrk3FudtkBEXmOhBeolmPMuGEV69cguyi2T2eFwPohQUfwsHNbHp3mzzM5EqrRKsASbUgrUXceth4MIa8c4/79IzDOU8GFecfs/gQ6Op8VO6jTdTptHCbM7VvX0OrE/NFZbd14mkw==",
		
		//异步通知地址
		'notify_url' => "http://www.tp0301.com/index/cart/notify_url.php",
		
		//同步跳转
		'return_url' => "http://www.tp0301.com/index/cart/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgJtPU/5IgZtSc1gt/zqWVZkltF/LjCavrp7p51f2qRIrr6rB17EcgnnvhU7Oj4mu/CuJ96i1uJwRWNGmekK9P/6KAzd9rNHDCh/+QZ+363wuAq/XozrPgODcLLuu/bCqw2pLG39AIndRNkqqh6jbaOnhiLCyQvD0B87i7QTUI7FDC02sJlaBDFwImL+j7bWk4pzSsDDCP9cqUvjZdC7hJjisdoA32yL7Gm7Ub9hxMVZdslUf1Omd3RAZB3PC0F0rmIGBh8OES7ZQLHXfO8+tPkQruoC9p6fTs5dJZVk6QnL7WGndcKiKA01drt4AdhVxVXsxtay1EN6XR8pIdwG11QIDAQAB",
		
	
);