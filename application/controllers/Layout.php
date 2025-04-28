<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (($this->session->userdata('logged') != TRUE)
            && ($this->session->userdata('access') != 'TxT')
        ) {
            $url = base_url('login');
            redirect($url);
        };

        $this->load->model('admin/M_administrator', 'M_administrator');
    }

    protected function layout($contents, $data = null)
    {
        $navs_home = [
            'label' => 'Home',
            'nav-items' => [
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav_home(
                            [
                                'href' => 'administrator',
                                'icon' => 'ti ti-layout-dashboard',
                                'label' => 'Dashboard'
                            ]
                        ),
                        true
                    )
                ]
            ]
        ];
        $navs_master = [
            'label' => 'Master',
            'nav-items' => [
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => 'administrator/master/akun',
                                'icon' => 'ti ti-receipt',
                                'label' => 'Akun'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => 'administrator/master/pos-tagihan',
                                'icon' => 'ti ti-receipt',
                                'label' => 'Pos Tagihan'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_dropdown',
                        [
                            'active' => $this->navs_active('administrator/master/portal'),
                            'in' => $this->navs_in('administrator/master/portal'),
                            'icon' => 'ti ti-clipboard-list',
                            'label' => 'Portal',
                            'nav-items' => $this->navs([
                                [
                                    'href' => 'administrator/master/portal-krs',
                                    'label' => 'KRS'
                                ],
                                [
                                    'href' => 'administrator/master/portal-uts',
                                    'label' => 'UTS'
                                ],
                                [
                                    'href' => 'administrator/master/portal-uas',
                                    'label' => 'UAS'
                                ]
                            ])
                        ],
                        true
                    )
                ]
            ]
        ];
        $navs_penerimaan = [
            'label' => 'Penerimaan',
            'nav-items' => [
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_dropdown',
                        [
                            'active' => $this->navs_active('administrator/penerimaan/pmb'),
                            'in' => $this->navs_in('administrator/penerimaan/pmb'),
                            'icon' => 'ti ti-school',
                            'label' => 'PMB',
                            'nav-items' => $this->navs([
                                [
                                    'href' => 'administrator/penerimaan/pmb/registrasi',
                                    'label' => 'Registrasi'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/pmb/daftar-ulang',
                                    'label' => 'Daftar Ulang'
                                ]
                            ])
                        ],
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => 'administrator/penerimaan/ukt',
                                'icon' => 'ti ti-cash',
                                'label' => 'UKT'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => 'administrator/penerimaan/pos-tagihan',
                                'icon' => 'ti ti-receipt',
                                'label' => 'Pos Tagihan'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_dropdown',
                        [
                            'active' => $this->navs_active('administrator/penerimaan/beasiswa'),
                            'in' => $this->navs_in('administrator/penerimaan/beasiswa'),
                            'icon' => 'ti ti-certificate',
                            'label' => 'Beasiswa',
                            'nav-items' => $this->navs([
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/baznas-kota-bandung',
                                    'label' => 'BAZNAS Kota Bandung'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/baznas-ri',
                                    'label' => 'BAZNAS RI'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/dakwah-keumatan',
                                    'label' => 'Dakwah Keumatan'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/guru',
                                    'label' => 'Guru'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/hafizh',
                                    'label' => 'Hafizh'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/kader-muhammadiyah',
                                    'label' => 'Kader Muhammadiyah'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/kip',
                                    'label' => 'KIP'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/lazismu-kl',
                                    'label' => 'Lazismu KL'
                                ],
                                [
                                    'href' => 'administrator/penerimaan/beasiswa/prestasi',
                                    'label' => 'Prestasi'
                                ]
                            ])
                        ],
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-gift-card',
                                'label' => 'Dana Hibah'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-briefcase',
                                'label' => 'Dana Amal Usaha'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-border-all',
                                'label' => 'Dana Lainnya'
                            ]
                        ),
                        true
                    )
                ]
            ]
        ];
        $navs_pengeluaran = [
            'label' => 'Pengeluaran',
            'nav-items' => [
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-building',
                                'label' => 'Sarana Prasarana'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-building-warehouse',
                                'label' => 'Non Sarana Prasarana'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-package',
                                'label' => 'Pemeliharaan Aset'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-receipt-2',
                                'label' => 'Pembayaran Remunerasi'
                            ]
                        ),
                        true
                    )
                ]
            ]
        ];
        $navs_pelaporan = [
            'label' => 'Pelaporan',
            'nav-items' => [
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-activity',
                                'label' => 'Keuangan Kegiatan'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-building-estate',
                                'label' => 'Operasional Universitas'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-luggage',
                                'label' => 'Operasional Unit Kerja'
                            ]
                        ),
                        true
                    )
                ]
            ]
        ];
        $navs_pajak = [
            'label' => 'Pajak',
            'nav-items' => [
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-chart-line',
                                'label' => 'PPN'
                            ]
                        ),
                        true
                    )
                ],
                [
                    'item' => $this->parser->parse(
                        '_layouts/components/navs/nav_item',
                        $this->nav(
                            [
                                'href' => '#',
                                'icon' => 'ti ti-calendar',
                                'label' => 'PPh'
                            ]
                        ),
                        true
                    )
                ]
            ]
        ];

        return $this->parser->parse('_layouts/base', [
            'head' => $this->parser->parse('_partials/head', [], true),
            'sidebar' => $this->parser->parse('_partials/sidebar', [
                'sidebar-items' => [
                    $navs_home,
                    $navs_master,
                    $navs_penerimaan,
                    $navs_pengeluaran,
                    $navs_pelaporan,
                    $navs_pajak
                ]
            ], true),
            'header' => $this->parser->parse('_partials/header', [], true),
            'contents' => $this->load->view($contents, $data, true),
            'footer' => $this->parser->parse('_partials/footer', [], true),
            'script' => $this->parser->parse('_partials/script_minimal', [], true)
        ]);
    }

    private function nav_home($data)
    {
        $data['active'] = fnmatch($data['href'], uri_string()) ? 'active' : '';

        return $data;
    }

    private function nav($data)
    {
        $data['active'] = fnmatch($data['href'] . '*', uri_string()) ? 'active' : '';

        return $data;
    }

    private function navs_active($href)
    {
        $active = fnmatch($href . '*', uri_string()) ? 'active' : '';
        return $active;
    }

    private function navs_in($href)
    {
        $in = fnmatch($href . '*', uri_string()) ? 'in' : '';
        return $in;
    }

    private function navs($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['dropdown'] = fnmatch($data[$i]['href'] . '*', uri_string()) ? 'dropdown' : '';
            $data[$i]['icon'] = fnmatch($data[$i]['href'] . '*', uri_string()) ? 'ti ti-circle-filled' : 'ti ti-circle';
        }

        return $data;
    }
}
