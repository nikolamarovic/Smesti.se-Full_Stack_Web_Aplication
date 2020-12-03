<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GostFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $session = session();
        if($session->has('korisnik'))
            return redirect()->to(site_url('Korisnik'));
        if($session->has('oglasavac'))
            return redirect()->to(site_url('Oglasavac'));
        if($session->has('admin'))
            return redirect()->to(site_url('Admin'));
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}