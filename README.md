![Seeder](http://media.hellofrancesco.com/seeder.png "Seeder Logo")

Introduction
--------------------

Seeder is a simple PHP Data Seed utility for random data generation. 

I created it because I needed a flexible and easy-to-use tool like this for my projects.

I also created it for practicing magic methods. For this reason, Seeder makes extensive use of them.

Let's see how to use it.

Getting Started
--------------------

First of all, download the latest package. 

Extract it wherever you want and you're ready to use it.

The next step is to include the seeder.php file and create a class instance in your application code:

```php
// including seeder.php file
require_once 'seeder/seeder.php';

$s = new Seeder();
```

After that, you can use your object as you want.

```php
// echoes a random first name.
// example: Kyle
echo $s->People->firstName;

// echoes a random company name
// example: Alvarado's Recreational Goods
echo $s->Business->companyName;

// echoes a random internet domain
// example: brightresidential.com
echo $s->Internet->domain;
```

Easy, huh?

Also, if you need control over your generator, you can specify the seed value.

```php
$s->seed(20);
echo $s->People->firstName;
// example output: Kyle

$s->seed(20);
echo $s->People->firstName;
// example output: Kyle (again)
```

Now, let's see something more about the project structure.


Project Structure
--------------------

Whenever I create something new I like to imagine the simplest final syntax. Then I work
to reach the result. No exception for Seeder.

At the beginning, the desired result was something like:

$seeder->Context_Here->Data_Type_Name_Here;

So, what if I wanted a person first name?

Here it is:

```php
echo $s->People->firstName;
```

Nothing less, nothing more. 

In Seeder, the Context is called Generator. Actually, the project has 9 generators.

Here they are, with examples related methods you can use. 

* Business

```php
// Generates a random company name.
echo $s->Business->companyName;
```

* HTML

```php
// Generates a paragraph random tag with some contents.
echo $s->HTML->p;
// Generates an img random tag using the placehold.it service.
echo $s->HTML->img;
```

* Internet

```php
// Generates a random domain.
echo $s->Internet->domain;
// Generates a random ipv4 address.
echo $s->Internet->ipv4;
```

* Misc

```php
// Generates a random sha512 hash.
echo $s->Misc->sha512;
// Generates a random hex color code.
echo $s->Misc->color;
```

* People

```php
// Generates a random full name.
echo $s->People->fullName;
// Generates a random first name.
echo $s->People->firstName;
```

* Phones

```php
// Generates a random phone number.
echo $s->Phone->number;
```

* Places

```php
// Generates a random city name.
echo $s->Places->city;
// Generates a random street name.
echo $s->Places->street;
```

* Text

```php
// Generates a random group of words.
echo $s->Text->words;
// Generates a random sentence.
echo $s->Text->sentence;
```

* Time

```php
// Generates a random year.
echo $s->Time->year;
// Generates a random date.
echo $s->Time->date;
```

Of course you can customize many method calls to get a specific result.

What if we want an healthcare company name?

```php
echo $s->Business->companyName('healthcare');
```

Good but not enough? Here's what to do if you want only financial and healthcare companies.

```php
echo $s->Business->companyName('healthcare, financial');
```

Maybe you want to define a specific format for your generated phone numbers:

```php
echo $s->Phones->number('nnn-nnn-nnnn');
```

And so on. For more info, check out the Generators Reference.


Customizations #1: Creating/Modifying Generators
--------------------

Seeder's generators are stored in the "generators" folder.

Generators have a defined name structure and file organization. 

Let's see an example: open the "generators/generator_people.php" file.

Here's the code:

```php
<?php

/**
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_People extends Generator_Base {

    var $fullNameFormats = array(
        '{People:firstName} {People:lastName}',
        '{People:firstName} {People:firstName} {People:lastName}',
        '{People:firstName} {People:firstName (0,1)}. {People:lastName}'
    );
    
    /**
     * Generates a random full name.
     *  
     * @access	public
     * @return  string
     */
    public function fullName() {
        return $this->format($this->choose($this->fullNameFormats));
    }

}

// end of: generator_people.php
// location: ./generators/generator_people.php
```

If I use the following syntax:

```php
echo $s->People->fullName;
```

The "People" will be used to search for the "generator_people.php" file and then to search the "Generator_People" class.

If one of them doesn't exists, the Seeder will output an error message.

Ok, why don't we try to create a new generator? Let's call it "generator_cars".

First of all, make a copy of "_generator_template.php" file. It's a template, really useful while creating new generators!

Rename the copy as "generator_cars.php". Now the code.

Change the code, starting from:

```php
<?php

/**
 * _Generator_Template Class
 *
 * You can use this class to create your own custom generator. Just copy it in
 * this folder, use the name you want (example "Generator_Custom") and then
 * make some good code!
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class _Generator_Template extends Generator_Base {
    
    /* Example Method */
    public function method() {
        return 'value';
    }

}

// end of: _generator_template.php
// location: ./generators/_generator_template.php
```

and arriving to:

```php
<?php

/**
 * Generator_Cars Class
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Cars extends Generator_Base {
    
    var $brandsList = array('Lamborghini', 'Ferrari', 'Maserati');

    public function brand(){
        return $this->choose($this->brandList);
    }

}

// end of: generator_cars.php
// location: ./generators/generator_cars.php
```

Here we go. Let's try to call our new generator:

```php
// example output: Lamborghini
echo $s->Cars->brand;
```

It's really easy to create a new Generator and use it in our projects. 

As you maybe noticed looking at the code, every generator belongs to the "Generator_Base" class.

This is the base class for every generator, containing many useful methods as "choose()", that extracts a random element from an array, or "format()", an useful methods that can perform many complex operations.

Now, let's see something about Data Files and how to use them to customize our sample data.


Customizations #2: Useful Methods (choose(), format(), parse())
--------------------

The Generator_Base class has three useful methods.

* choose(), used to extract a random element from an array;
* format(), used to generate a random string using a starting "format" string;
* parse(), used to generate complex fields using other generators or methods;

Let's take a look at them.

### choose()

The "choose()" method is really simple. Just use it to extract a random element from an array, like this:

```php
<?php

$s->Generator->choose($data);
```

Nothing really exciting, I know. It's just an utility method.

### format()

This method is really useful when you have to generate strings of a precise type.

So, if you want to generate a string like "nnn-nn-nn-nn", where every "n" is a digit, just use:

```php
<?php

$s->Generator->format('nnn-nn-nn-nn');
```

Some output examples are: 123-33-44-55 or 555-23-67-43.

Of course you can have some fixed values:

```php
<?php

$s->Generator->format('555-nn-nn-nn');
```

will output something like 555-12-34-56 or 555-67-34-12.

### parse()

Parse is an useful method that helps you creating complex random values, using other generators.

Just to make an example, let's take a look to the code of Internet->username method:

```php
var $usernameFormats = array(
    '{People:firstName}.{People:lastName}',
    '{People:lastName}.{People:firstName}',
    '{People:firstName (0,1)}.{People:lastName}',
    '{People:lastName (0,1)}.{People:firstName}',
    '{People:firstName (0,1)}{People:lastName}',
    '{People:lastName (0,1)}{People:firstName}',
    '{People:lastName (0,3)}{People:firstName (0,3)}',
    '{People:firstName (0,3)}{People:lastName (0,3)}'
);

/**
* Generates a random username, based on people first and
* last names.
* 
* Example:
*      Name: John, Last Name: Smith
* 
* Result:
*      j.smith@domain.com
*      john.smith@domain.com
*  
* @access	public
* @param	string  $min    The lower desired ip
* @param	string  $max    The higher desired ip
* @return  string
*/
public function username($format = '') {
   if ($format == '')
       $format = $this->choose($this->usernameFormats);

   $format = $this->parse($format);
   return strtolower($format);
}
```

First of all, we choose a random entry from the $usernameFormats array. Then, we use that entry as a parameter for the "parse()" method.

This method will be generate a random value for each {Generator_Here:Method_Here} occurrence in the string.

So, if we use '{People:firstName}.{People:lastName}', "parse()" will generate a first name and a last name, respecting the string structure.

Example results at the end: "john.smith".

You can also make a substring operation if you want. 

Let's generate an username using the first letter of the first name, a dot and all the last name ('{People:firstName (0,1)}.{People:lastName}').

Here's the result: "j.smith".

Important: you can also call methods from other generators!!!

Example:

'{People:firstName} - {Business:sector}'

Useful, huh? ;)

Customizations #3: Data Files
--------------------

In the previous example I've used an array into the Generator_Cars class. Let's see a more elegant solution: Data Files.

Data Files are nothing but containers for every kind of data we want to use with Seeder.

They are composed by a bunch of arrays, and they can be two-dimensional or one-dimensional (simple lists).

Let's take a look to "data/data_people.php".

```php
<?php

$data['firstName']['male'] = array(
    'James', 'John', 'Robert', ... , 'Andrea');


$data['firstName']['female'] = array(
    'Mary', 'Patricia', 'Linda', ... , 'Augusta');

$data['lastName'] = array(
    'Smith', 'Johnson', 'Williams', ... , 'Cooke');
```

As you can see in the "generators/generator_people.php" file, there is no "lastName" method.

But if you type

```php
echo $s->People->lastName;
```

you'll get a random lastName. What's goin'on there?

Really simple. When you specify what kind of data do you need, Seeder does many things.

Here's what happens when you call the People->lastName method:

* Seeder loads the "generators/generator_people.php" file;
* Seeder loads and creates an instance of Generator_People class;
* Seeder loads and the related Data_People file (and data), if it exists;
* Seeder looks for a method called "lastName()", but it doesn't exists;
* Seeder tries to find a key in the $data array named "lastName", in "data/data_people.php" file. Key exists, and Seeder extract a random entry from there, using the choose() method.

Here's our last name.

If we don't need to do complex operations all we have to do is to use the appropriate data file, without creating empty methods.

You can also see a two-dimensional array there, named "firstName". It contains, separately, male and female names.

What does it means? Well, if you need to generate only male names, here's the right syntax:

```php
echo $s->People->firstName('male');
```

But if you want every kind of name, just use

```php
echo $s->People->firstName;
```

This system is really useful when you have to deal with big two-dimensional arrays. Let's make another example, using cars.

Here's our data file:

```php
<?php

$data['car']['Lamborghini'] = array(
    'Murcielago', 'Gallardo', 'Aventador'
);

$data['car']['Maserati'] = array(
    'Quattroporte', 'GranTurismo', 'GranCabrio'
);

$data['car']['Ferrari'] = array(
    'F430 Spider', 'F50', 'Enzo'
);
```

If I want only Lamborghini Cars, I'll use

```php
echo $s->Cars->car('Lamborghini');
```

Now, what about if we want only Lamborghini and Maserati models?

```php
echo $s->Cars->car('Lamborghini, Maserati');
```

NOTE: even if you don't want to do complex operations, you'll always need a Generator if you want to use Data Files.

Complete Generators Reference
--------------------

Here's a complete list of what you can make with Seeder's random generators.

###Business Generator

```php
$s->Business->companySuffix;
$s->Business->sector;
$s->Business->companyName;
```

###HTML Generator

```php
$s->HTML->h1;
$s->HTML->h2;
$s->HTML->h3;
$s->HTML->h4;
$s->HTML->p;
$s->HTML->li;
$s->HTML->ul;
$s->HTML->img;
$s->HTML->div;
```

###Internet Generator

```php
$s->Internet->ipv4;
$s->Internet->ipv6;
$s->Internet->macAddress;
$s->Internet->companyMail;
$s->Internet->freeMail;
$s->Internet->freeMailDomain;
$s->Internet->username;
$s->Internet->password;
$s->Internet->domain;
$s->Internet->browser;
$s->Internet->domain;
$s->Internet->tld;
$s->Internet->userAgent;
$s->Internet->statusCode;
```

###Misc Generator

```php
$s->Misc->md5;
$s->Misc->sha1;
$s->Misc->sha256;
$s->Misc->sha512;
$s->Misc->hash;
$s->Misc->base64;
$s->Misc->color;
```

###People Generator

```php
$s->People->fullName;
$s->People->firstName;
$s->People->lastName;
```

###Phones Generator

```php
$s->Phones->number;
```

###Places Generator

```php
$s->Places->city;
$s->Places->citySuffix;
$s->Places->cityPrefix;
$s->Places->address;
$s->Places->street;
$s->Places->streetSuffix;
$s->Places->buildingNumber;
$s->Places->postalCode;
$s->Places->latitude;
$s->Places->longitude;
$s->Places->country;
$s->Places->state;
```

###Text Generator

```php
$s->Text->word;
$s->Text->words;
$s->Text->sentence;
$s->Text->sentences;
```

###Time Generator

```php
$s->Time->timestamp;
$s->Time->time;
$s->Time->date;
$s->Time->atom;
$s->Time->rss;
$s->Time->w3c;
$s->Time->rfc1036;
$s->Time->rfc2822;
$s->Time->year;
$s->Time->month;
$s->Time->day;
$s->Time->hour;
$s->Time->minute;
$s->Time->second;
$s->Time->timeZone;
$s->Time->textWeekday;
$s->Time->textMonth;
```

(Complete reference will be available soon!)

Conclusion
--------------------

That's my first project here on GitHub (and ApiGen documentation, that will be available soon), I hope you'll enjoy it! If you need anything you can ask me at hellofrancesco@gmail.com.

Of course, I want to improve myself as a programmer: if you have any kind of hint you're welcome! ;)
