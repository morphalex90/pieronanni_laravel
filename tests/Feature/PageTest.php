<?php

it('correctly shows homepage', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('correctly shows about page', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
});

it('correctly shows projects page', function () {
    $response = $this->get('/projects');

    $response->assertStatus(200);
});

it('correctly shows contact page', function () {
    $response = $this->get('/contact');

    $response->assertStatus(200);
});
