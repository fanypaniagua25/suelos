<?php

use Modules\Suelos\Models\Suelo;

uses(Tests\TestCase::class);

test('can see suelo list', function() {
    $this->authenticate();
   $this->get(route('app.suelos.index'))->assertOk();
});

test('can see suelo create page', function() {
    $this->authenticate();
   $this->get(route('app.suelos.create'))->assertOk();
});

test('can create suelo', function() {
    $this->authenticate();
   $this->post(route('app.suelos.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.suelos.index'));

   $this->assertDatabaseCount('suelos', 1);
});

test('can see suelo edit page', function() {
    $this->authenticate();
    $suelo = Suelo::factory()->create();
    $this->get(route('app.suelos.edit', $suelo->id))->assertOk();
});

test('can update suelo', function() {
    $this->authenticate();
    $suelo = Suelo::factory()->create();
    $this->patch(route('app.suelos.update', $suelo->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.suelos.index'));

    $this->assertDatabaseHas('suelos', ['name' => 'Joe Smith']);
});

test('can delete suelo', function() {
    $this->authenticate();
    $suelo = Suelo::factory()->create();
    $this->delete(route('app.suelos.delete', $suelo->id))->assertRedirect(route('app.suelos.index'));

    $this->assertDatabaseCount('suelos', 0);
});