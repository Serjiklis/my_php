<?php
function print_ar($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

interface DeliveryType
{
	public function getDeliveryName();
}


class Novaposhta implements DeliveryType
{
	const DELIVERY_NAME = 'Новая Почта';

	public function getDeliveryName()
	{
		return self::DELIVERY_NAME;
	}
}


class Ukrposhta implements DeliveryType
{
	const DELIVERY_NAME = 'Укрпочта';

	public function getDeliveryName()
	{
		return self::DELIVERY_NAME;
	}
}


interface PaymentType
{
	public function getPaymentName();
}


class Liqpay implements PaymentType
{
	const PAYMENT_NAME = 'LiqPay';

	public function getPaymentName()
	{
		return self::PAYMENT_NAME;
	}
}


class Monobank implements PaymentType
{
	const PAYMENT_NAME = 'MonoPay';

	public function getPaymentName()
	{
		return self::PAYMENT_NAME;
	}
}

class User
{
	private string $name;
	private string $surname;

	public function __construct($name, $surname)
	{
		$this->name = $name;
		$this->surname = $surname;
	}

	public function getUserName()
	{
		return $this->name.' '.$this->surname;
	}
}

class Product
{
	private string $goodsName;
	private int $quantity;
	private float $price;
	public $goods = [];
	// метод возвращает ассоциативный масив $goods
	public function __construct($goodsName, $price, $quantity = 1)
	{
		$this->goodsName = $goodsName;
		$this->quantity = $quantity;
		$this->price = $price;

		$this->goods[$this->goodsName]['quantity'] = $this->quantity;
		$this->goods[$this->goodsName]['price'] = $this->price;
		return $this->goods;
	}


}

class Cart
{

	public $products = [];

	//методпринимает на вход массив
	public function addCart($goods)
	{
		foreach ($this->products as $key => $value)
		{
			//проверка на наличие ключа массива $goods в массиве $products
			if(array_key_exists($key, $goods))
			{
				//если такой товар уже есть в корзине получаем количество и складываем значения
				$goods[$key]['quantity'] = $this->products[$key]['quantity'] + $goods[$key]['quantity'];
				//объеденяем массивы с перезаписью строковых ключей
				$this->products = array_merge($this->products, $goods);

				return $this->products;

			}else {
				// добавляем массив $goods в массив $products
				$this->products += $goods;
				return $this->products;
			}

		}
	}

	public function getCartGoods()
	{
		return $this->products;
	}
}


class Order
{

}

// создаем объекты товаров
$dog = new Product('dog', 15,3);
$cat = new Product('cat', 10);
$bird = new Product('bird', 7,2);

// получаем массив с товаром
$dogGoods = $dog->goods;
$catGoods = $cat->goods;
$birdGoods = $bird->goods;

//проверка структуры массива
print_ar($catGoods);

//создаем козину
$cart = new Cart();

//добавляем полученные товары в виде массивов в корзину
$cart->addCart($dogGoods);
$cart->addCart($catGoods);
$cart->addCart($birdGoods);
$cart->addCart($dogGoods);

print_ar($cart);


