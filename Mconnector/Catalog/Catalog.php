<?php

/**
 * The Initial Developer of the Original Code is
 * Tarmo Alexander Sundström <ta@sundstrom.im>.
 *
 * Portions created by the Initial Developer are
 * Copyright (C) 2017 Tarmo Alexander Sundström <ta@sundstrom.im>
 *
 * All Rights Reserved.
 *
 * Contributor(s):
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
namespace Mconnector\Catalog;

use Libvaloa\Debug;
use Mconnector\Connection\Connection as RestApiConnection;

class Catalog
{
    private $connection;

    const CATALOG_CATEGORY_ENDPOINT = '/index.php/rest/V1/categories/:categoryId/products';

    public function __construct()
    {
        $this->connection = new RestApiConnection();

        // Get authentication token
        $this->connection->getAuthenticationToken();
    }

    public function getCatalogByCategoryId($id)
    {
        $endpoint = str_replace(':categoryId', $id, self::CATALOG_CATEGORY_ENDPOINT);
        $catalog = $this->connection->call($endpoint);

        if ($catalog) {
            $this->view->catalog = json_decode($catalog);

            Debug::__print($this->view->catalog);
        } else {
            Debug::__print('Catalog products not found.');
        }
    }
}
