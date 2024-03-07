<?php

use Modules\Coberturasuelos\Models\Coberturasuelo;

uses(Tests\TestCase::class);

test('can see coberturasuelo list', function() {
    $this->authenticate();
   $this->get(route('app.coberturasuelos.index'))->assertOk();
});

test('can see coberturasuelo create page', function() {
    $this->authenticate();
   $this->get(route('app.coberturasuelos.create'))->assertOk();
});

test('can create coberturasuelo', function() {
    $this->authenticate();
   $this->post(route('app.coberturasuelos.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.coberturasuelos.index'));

   $this->assertDatabaseCount('coberturasuelos', 1);
});

test('can see coberturasuelo edit page', function() {
    $this->authenticate();
    $coberturasuelo = Coberturasuelo::factory()->create();
    $this->get(route('app.coberturasuelos.edit', $coberturasuelo->id))->assertOk();
});

test('can update coberturasuelo', function() {
    $this->authenticate();
    $coberturasuelo = Coberturasuelo::factory()->create();
    $this->patch(route('app.coberturasuelos.update', $coberturasuelo->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.coberturasuelos.index'));

    $this->assertDatabaseHas('coberturasuelos', ['name' => 'Joe Smith']);
});

test('can delete coberturasuelo', function() {
    $this->authenticate();
    $coberturasuelo = Coberturasuelo::factory()->create();
    $this->delete(route('app.coberturasuelos.delete', $coberturasuelo->id))->assertRedirect(route('app.coberturasuelos.index'));

    $this->assertDatabaseCount('coberturasuelos', 0);
});