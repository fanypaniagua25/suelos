<?php

use Modules\Cultivos\Models\Cultivo;

uses(Tests\TestCase::class);

test('can see cultivo list', function() {
    $this->authenticate();
   $this->get(route('app.cultivos.index'))->assertOk();
});

test('can see cultivo create page', function() {
    $this->authenticate();
   $this->get(route('app.cultivos.create'))->assertOk();
});

test('can create cultivo', function() {
    $this->authenticate();
   $this->post(route('app.cultivos.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.cultivos.index'));

   $this->assertDatabaseCount('cultivos', 1);
});

test('can see cultivo edit page', function() {
    $this->authenticate();
    $cultivo = Cultivo::factory()->create();
    $this->get(route('app.cultivos.edit', $cultivo->id))->assertOk();
});

test('can update cultivo', function() {
    $this->authenticate();
    $cultivo = Cultivo::factory()->create();
    $this->patch(route('app.cultivos.update', $cultivo->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.cultivos.index'));

    $this->assertDatabaseHas('cultivos', ['name' => 'Joe Smith']);
});

test('can delete cultivo', function() {
    $this->authenticate();
    $cultivo = Cultivo::factory()->create();
    $this->delete(route('app.cultivos.delete', $cultivo->id))->assertRedirect(route('app.cultivos.index'));

    $this->assertDatabaseCount('cultivos', 0);
});