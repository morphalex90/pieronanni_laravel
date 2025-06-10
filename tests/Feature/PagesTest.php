<?php

it('returns a successful response on homepage', function () {
    $response = $this->get('/');
    $response->assertStatus(200);

});

it('returns a successful response on about page', function () {
    $response = $this->get('/about');
    $response->assertStatus(200);
});

it('returns a successful response on projects page', function () {
    $response = $this->get('/projects');
    $response->assertStatus(200);
});

it('returns a successful response on contact page', function () {
    $response = $this->get('/contact');
    $response->assertStatus(200);
});

// it('returns a successful response on cv page', function () {
//     $response = $this->get('/cv');
//     $response->assertStatus(200);
// });
