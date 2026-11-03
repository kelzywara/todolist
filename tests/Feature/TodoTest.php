<?php

use App\Models\Todo;

test('the task list displays every task', function () {
    Todo::create(['title' => 'Tugas pertama', 'description' => 'Deskripsi pertama']);
    Todo::create(['title' => 'Tugas kedua', 'is_completed' => true]);

    $this->get(route('todos.index'))
        ->assertOk()
        ->assertSee('Tugas pertama')
        ->assertSee('Tugas kedua')
        ->assertSee('Daftar tugas');
});

test('open tasks are listed before completed tasks', function () {
    Todo::create(['title' => 'Sudah selesai', 'is_completed' => true]);
    Todo::create(['title' => 'Belum selesai', 'is_completed' => false]);

    $this->get(route('todos.index'))
        ->assertOk()
        ->assertSeeInOrder(['Belum selesai', 'Sudah selesai']);
});

test('the create page is reachable', function () {
    $this->get(route('todos.create'))
        ->assertOk()
        ->assertSee('Mulai dari');
});

test('a task can be stored', function () {
    $this->post(route('todos.store'), [
        'title' => 'Menulis dokumentasi',
        'description' => 'Lengkapi bagian instalasi.',
        'is_completed' => '1',
    ])
        ->assertRedirect(route('todos.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('todos', [
        'title' => 'Menulis dokumentasi',
        'description' => 'Lengkapi bagian instalasi.',
        'is_completed' => true,
    ]);
});

test('a task title is required', function () {
    $this->post(route('todos.store'), [
        'title' => '',
        'description' => 'Tanpa judul.',
    ])->assertSessionHasErrors('title');

    $this->assertDatabaseCount('todos', 0);
});

test('a task detail page is reachable', function () {
    $todo = Todo::create(['title' => 'Cek detail', 'description' => 'Isi detail tugas.']);

    $this->get(route('todos.show', $todo))
        ->assertOk()
        ->assertSee('Cek detail')
        ->assertSee('Isi detail tugas.');
});

test('the edit page is reachable', function () {
    $todo = Todo::create(['title' => 'Tugas yang diedit']);

    $this->get(route('todos.edit', $todo))
        ->assertOk()
        ->assertSee('Tugas yang diedit');
});

test('a task can be updated', function () {
    $todo = Todo::create(['title' => 'Judul lama', 'is_completed' => false]);

    $this->put(route('todos.update', $todo), [
        'title' => 'Judul baru',
        'description' => 'Deskripsi baru.',
        'is_completed' => '1',
    ])
        ->assertRedirect(route('todos.index'))
        ->assertSessionHas('success');

    $todo->refresh();

    expect($todo->title)->toBe('Judul baru')
        ->and($todo->description)->toBe('Deskripsi baru.')
        ->and($todo->is_completed)->toBeTrue();
});

test('a task can be toggled complete', function () {
    $todo = Todo::create(['title' => 'Tugas toggle', 'is_completed' => false]);

    $this->patch(route('todos.toggle', $todo))->assertRedirect();

    expect($todo->fresh()->is_completed)->toBeTrue();
});

test('a completed task can be toggled back to open', function () {
    $todo = Todo::create(['title' => 'Tugas toggle', 'is_completed' => true]);

    $this->patch(route('todos.toggle', $todo))->assertRedirect();

    expect($todo->fresh()->is_completed)->toBeFalse();
});

test('a task can be deleted', function () {
    $todo = Todo::create(['title' => 'Tugas dihapus']);

    $this->delete(route('todos.destroy', $todo))
        ->assertRedirect(route('todos.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
});
