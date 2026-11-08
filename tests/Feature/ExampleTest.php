<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * La página principal redirige al listado de comercios.
     */
    public function test_the_application_redirects_to_comercios(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('comercios.index'));
    }
}
