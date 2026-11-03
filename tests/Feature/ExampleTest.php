<?php

test('the root path redirects to the todo list', function () {
    $this->get('/')->assertRedirect('/todos');
});
