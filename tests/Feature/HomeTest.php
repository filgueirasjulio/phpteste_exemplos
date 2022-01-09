<?php

use Tests\TestCase;

use function Pest\Laravel\actingAs;

/** Metódos já existentes no php unit **/
it('has a simple result true', function() {
    /** @var TestCase $this */

    $this->assertTrue(true);
});

it('has a result false', function() {
    /** @var TestCase $this */

    $this->assertFalse(false);
});

it('has a correctly result count', function() {
    /** @var TestCase $this */

    $array = [1, 2, 3, 4];
    $this->assertCount(4, $array);
});

it('has a equals arrays', function() {
    /** @var TestCase $this */

    $array = [1, 2, 3, 4];
    $this->assertEquals([1, 2, 3, 4], $array);
});

it('if string contains string', function() {
     /** @var TestCase $this */
     $string = 'Olá, tudo bem com vocês ?';

     $this->assertStringContainsString('Olá', $string);
});

/** Metódos pest */
it('shows an expectation toBe', function() {
    $id = 1;
    $name = 'Júlio';

    expect($id)->toBe(1)->and($name)->toBe('Júlio');
});

it('shows an expectation toBeInt', function() {
    $numbers = [1, 2, 3];

    expect($numbers)->each->toBeInt();
    expect($numbers)->each->not->toBeString();
});

it('shows an expectation toBeString', function() {
    $words = ["maça", "banana", "laranja"];

    expect($words)->each->toBeString();
    expect($words)->each->not->toBeInt();
});

it('check number value', function() {
    $numbers = [1, 2, 3];

   expect($numbers)->each(fn ($number) => $number->toBeLessThan(4));
});

it('shows an expectation sequence', function() {
    $numbers = [1, 2, 3];
   
    expect($numbers)->sequence(
        fn ($number) => $number->toBe(1),
        fn ($number) => $number->toBe(2),
        fn ($number) => $number->toBe(3),
    );
});

it('check if value is empty', function() {
    $lastSeen = collect([]);

    expect($lastSeen)->toBeEmpty();
});

it('check if value is true', function() {
   $published = true;

    expect($published)->toBeTrue();
    //expect($published)->toBeFalse();
});

it('check if value is greater than', function() {
    $age = 34;
 
    expect($age)->toBeGreaterThan(30);
    expect($age)->toBeGreaterThanOrEqual(34);
 });

 it('check if value is less than', function() {
    $age = 34;
 
    expect($age)->toBeLessThan(40);
    expect($age)->toBeLessThanOrEqual(34);
 });

 it('check if string contain value', function() {
    $string = "Oi, eu me chamo Júlio";
    expect($string)->toContain('chamo Júlio');
 });

 it('check if array have count', function() {
    $array = ['Júlio', 'Gabriel', 'Luisa'];

    expect($array)->toHaveCount(3);
 });

 it('check if class have a property', function() {
    $user = new class {
        public $name = 'Júlio';
    };

    expect($user)->toHaveProperty('name', 'Júlio');
 });

 it('check match array', function() {
    $user = [
        'id' => 1,
        'name' => 'Júlio',
        'email' => 'julio@dindigital.com',
    ];

    $value = [
        'name' => 'Júlio',
        'email' => 'julio@dindigital.com',
    ];

    expect($user)->toMatchArray($value);
 });

 
 it('check match object', function() {
    $user = new stdClass();
    $user->id = 1;
    $user->email = 'julio@dindigital.com';
    $user->name = 'Júlio';

    $value = new stdClass();
    $value->email = 'julio@dindigital.com';
    $value->name = 'Júlio';

    expect($user)->toMatchObject($value);
    //é possível comparar também objeto com array
 });

 it('check equals value', function() {
    $title = 'Hello World';
    expect($title)->toEqual('Hello World');
 });

 it('check equals two values', function() {
   $expected = [4, 2, 1];
   $value = [2, 4, 1];

   expect($expected)->toEqualCanonicalizing($value); //verifica os valores, mas não a ordem
});

it('check equals with delta', function() {
    $expected = 10;
    $value = 14;
    $delta = 5;
 
    expect($expected)->toEqualWithDelta($value, $delta); //a diferença entre o valor (absoluto) deve ser menor ou igual que o delta
 });

 
 it('check if value is infinite', function() {
    $universe = INF;
    expect($universe)->toBeInfinite();
 });

 it('check if value is a instance', function() {
    $user = new \App\Models\User();

    expect($user)->toBeInstanceOf(\App\Models\User::class);
 });

 it('check if value is a array', function() {
    $fruits = ["maça", "banana", "laranja"];

    expect($fruits)->toBeArray();
 });

 it('check if result is json', function() {
    $result = '{"success": true}';

    expect($result)->toBeJson();
 });

 it('check key exists', function() {
    $result = [
        'success' => true,
        'message' => 'Hey guy!',
    ];

    expect($result)->toHaveKeys(['success', 'message']);
 });


 //criar expections personalizadas
 expect()->extend('toBeWithinRange', function($min, $max) {
    return $this->toBeGreaterThanOrEqual($min)
            ->toBeLessThanOrEqual($max);
 });

 it('numeric ranges', function() {
    expect(100)->toBeWithinRange(90, 110);
 });

 //teste de ordem superior
 it('true is true')->assertEquals('oi', 'oi');

 //ignorar um middleware para fazer um teste
 beforeEach()->withoutMiddleware();

 it('has home')
    ->get('/')
    ->assertSee('Documentation');

it('redirect to user profile', function() {
    $user = \App\Models\User::factory()->create();

    actingAs($user)->get('/')->assertSee('Documentation');
});

//verificar exception
it('throws exception', function() {
    throw new Exception('Algo deu errado');
})->throws(Exception::class, 'Algo deu errado');
