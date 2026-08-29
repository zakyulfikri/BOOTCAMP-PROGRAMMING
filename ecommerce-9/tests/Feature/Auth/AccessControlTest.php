<?php

test('guests are redirected to login when visiting protected pages', function () {
    $this->get('/dashboard')->assertRedirect('/login');
    $this->get('/products')->assertRedirect('/login');
    $this->get('/categories')->assertRedirect('/login');
});
