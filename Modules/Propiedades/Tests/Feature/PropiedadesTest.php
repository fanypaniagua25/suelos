<?php

use Modules\Propiedades\Models\Propiedade;

uses(Tests\TestCase::class);

test('can see propiedade list', function() {
    $this->authenticate();
   $this->get(route('app.propiedades.index'))->assertOk();
});

test('can see propiedade create page', function() {
    $this->authenticate();
   $this->get(route('app.propiedades.create'))->assertOk();
});

test('can create propiedade', function() {
    $this->authenticate();
   $this->post(route('app.propiedades.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.propiedades.index'));

   $this->assertDatabaseCount('propiedades', 1);
});

test('can see propiedade edit page', function() {
    $this->authenticate();
    $propiedade = Propiedade::factory()->create();
    $this->get(route('app.propiedades.edit', $propiedade->id))->assertOk();
});

test('can update propiedade', function() {
    $this->authenticate();
    $propiedade = Propiedade::factory()->create();
    $this->patch(route('app.propiedades.update', $propiedade->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.propiedades.index'));

    $this->assertDatabaseHas('propiedades', ['name' => 'Joe Smith']);
});

test('can delete propiedade', function() {
    $this->authenticate();
    $propiedade = Propiedade::factory()->create();
    $this->delete(route('app.propiedades.delete', $propiedade->id))->assertRedirect(route('app.propiedades.index'));

    $this->assertDatabaseCount('propiedades', 0);
});