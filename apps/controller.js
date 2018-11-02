angular
    .module("Ctrl", ["datatables", "datatables.buttons", "jlareau.pnotify"])

.controller("UserSession", function($scope, $http) {
    $scope.session = {};
    var Urlauth = "api/datas/read/auth.php";
    $http({
            method: "get",
            url: Urlauth,
        })
        .then(function(response) {
            if (response.data.Session == false) {
                window.location.href = 'index.html';
            } else
                $scope.session = response.data.Session;
        }, function(error) {})
})

.controller("MainController", function($scope, $http) {
    $scope.a = "Testing";
    $scope.session = {};
    var Urlauth = "api/datas/read/auth.php";
    $http({
            method: "get",
            url: Urlauth,
        })
        .then(function(response) {
            if (response.data.Session == false) {
                window.location.href = 'index.html';
            } else
                $scope.session = response.data.Session;
        }, function(error) {})

})

.controller("LoginController", function($scope, $http) {
    $scope.DatasLogin = {};
    $scope.Login = function() {
        var UrlLogin = "api/datas/read/UserLogin.php";
        var Data = angular.copy($scope.DatasLogin);
        $http({
            method: "POST",
            url: UrlLogin,
            data: Data
        }).then(function(response) {
            if (response.data.Session != undefined) {
                if (response.data.Session.akses == "admin")
                    window.location.href = "admin.html";
                else {
                    window.location.href = "pejabat.html";
                }


            } else
                alert(response.data.message);

        }, function(error) {
            alert(error.data.message);
        })
    }

})

.controller("PenggunaController", function(
    $scope,
    $http,
    DTOptionsBuilder,
    DTColumnBuilder,
    notificationService
) {
    $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType("full_numbers")
        .withOption("order", [1, "desc"])
        .withButtons([{
                extend: 'excelHtml5',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    // jQuery selector to add a border to the third row
                    $('row c[r*="3"]', sheet).attr('s', '25');
                    // jQuery selector to set the forth row's background gray
                    $('row c[r*="4"]', sheet).attr('s', '5');
                }
            },
            {
                extend: 'print',
                //text: 'Print current page',
                autoPrint: true,
                title: "Data Seleksi",
                exportOptions: {
                    columns: ':visible'
                }
            }

        ]);
    $scope.dtColumns = [
        DTColumnBuilder.newColumn("id").withTitle("ID"),
        DTColumnBuilder.newColumn("firstName").withTitle("First name"),
        DTColumnBuilder.newColumn("lastName").withTitle("Last name")
    ];
    $scope.DatasPengguna = [];
    $scope.DataInput = {};
    $scope.Init = function() {
        var Kategoriurl = "api/datas/read/ReadPengguna.php";
        $http({
            method: "Get",
            url: Kategoriurl
        }).then(
            function(response) {
                $scope.DatasPengguna = response.data.records;
            },
            function(error) {
                alert(error.message);
            }
        );
    };
    $scope.Simpan = function() {
        var Data = $scope.DataInput;
        var InsertUrl = "api/datas/create/CreatePengguna.php";
        $http({
            method: "POST",
            url: InsertUrl,
            data: Data
        }).then(
            function(response) {
                if (response.data.message > 0) {
                    $scope.DataInput.idpengguna = response.data.message;
                    $scope.DatasPengguna.push(angular.copy($scope.DataInput));
                    notificationService.success("Data Berhasil di Simpan");
                }
            },
            function(error) {
                notificationService.error("Gagal Simpan");
            }
        );
    };
})

.controller("StrukturalController", function(
    $scope,
    $http,
) {
    $scope.DatasStruktural = [];
    $scope.DataInput = {};
    $scope.Init = function() {
        var Url = "api/datas/read/ReadStruktural.php";
        $http({
            method: "Get",
            url: Url
        }).then(
            function(response) {
                if (response.data.records != undefined)
                    $scope.DatasStruktural = response.data.records;
            },
            function(error) {
                alert(error.message);
            }
        );
    };
    $scope.Simpan = function() {
        var Data = $scope.DataInput;
        var InsertUrl = "api/datas/create/CreateStruktural.php";
        $http({
            method: "POST",
            url: InsertUrl,
            data: Data
        }).then(
            function(response) {
                if (response.data.message > 0) {
                    $scope.DataInput.idstruktural = response.data.message;
                    $scope.DatasStruktural.push(angular.copy($scope.DataInput));
                    notificationService.success("Data Berhasil di Simpan");
                }
            },
            function(error) {
                notificationService.error("Gagal Simpan");
            }
        );
    };
})

.controller("PejabatController", function(
    $scope,
    $http,
    DTOptionsBuilder,
    DTColumnBuilder,
    notificationService
) {
    $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType("full_numbers")
        .withOption("order", [1, "desc"])
        .withButtons([{
                extend: 'excelHtml5',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    // jQuery selector to add a border to the third row
                    $('row c[r*="3"]', sheet).attr('s', '25');
                    // jQuery selector to set the forth row's background gray
                    $('row c[r*="4"]', sheet).attr('s', '5');
                }
            },
            {
                extend: 'print',
                //text: 'Print current page',
                autoPrint: true,
                title: "Data Seleksi",
                exportOptions: {
                    columns: ':visible'
                }
            }

        ]);
    $scope.dtColumns = [
        DTColumnBuilder.newColumn("id").withTitle("ID"),
        DTColumnBuilder.newColumn("firstName").withTitle("First name"),
        DTColumnBuilder.newColumn("lastName").withTitle("Last name")
    ];

    $scope.DatasPejabat = [];
    $scope.DatasStruktural = [];
    $scope.DatasPengguna = [];
    $scope.DataInput = {};
    $scope.SelectedPengguna = {};
    $scope.SelectedStruktural = {};
    $scope.Init = function() {


        var Url1 = "api/datas/read/ReadStruktural.php";
        $http({
            method: "Get",
            url: Url1
        }).then(
            function(response) {
                if (response.data.message == "No Struktural found")
                    alert(response.data.message);
                else
                    $scope.DatasStruktural = response.data.records;
            },
            function(error) {
                alert(error.message);
            }
        );

        var Kategoriurl = "api/datas/read/ReadPengguna.php";
        $http({
            method: "Get",
            url: Kategoriurl
        }).then(
            function(response) {
                $scope.DatasPengguna = response.data.records;
            },
            function(error) {
                alert(error.message);
            }
        );

        var Url = "api/datas/read/ReadPejabat.php";
        $http({
            method: "Get",
            url: Url
        }).then(
            function(response) {
                if (response.data.message == "No Pejabat found")
                    alert(response.data.message);
                else
                    $scope.DatasPejabat = response.data.records;
            },
            function(error) {
                alert(error.message);
            }
        );
    };
    $scope.Simpan = function() {
        $scope.DataInput.idpengguna = $scope.SelectedPengguna.idpengguna;
        $scope.DataInput.nama_pengguna = $scope.SelectedPengguna.nama_pengguna;
        $scope.DataInput.idstruktural = $scope.SelectedStruktural.idstruktural;
        $scope.DataInput.nm_struktural = $scope.SelectedStruktural.nm_struktural;
        $scope.DataInput.status = true;

        var Data = $scope.DataInput;
        var InsertUrl = "api/datas/create/CreatePejabat.php";
        $http({
            method: "POST",
            url: InsertUrl,
            data: Data
        }).then(
            function(response) {
                if (response.data.message > 0) {
                    $scope.DataInput.idpejabat = response.data.message;
                    angular.forEach($scope.DatasPejabat, function(value, key) {
                        if (value.idstruktural == $scope.DataInput.idstruktural) {
                            value.status = "false";
                        }
                    })
                    $scope.DatasPejabat.push(angular.copy($scope.DataInput));
                    notificationService.success("Data Berhasil di Simpan");

                }
            },
            function(error) {
                notificationService.error("Gagal Simpan");
            }
        );
    };
})

.controller("MailboxController", function($scope, $http, dataFactory) {
    $scope.DatasSuratInternal = [];

    $scope.Init = function() {
        var Url = "api/datas/read/ReadSuratInternal.php";
        $http({
            method: "GET",
            url: Url
        }).then(function(response) {

        }, function(error) {
            alert(error.data.message);
        })
    }

    $scope.tinymceModel = 'Initial content';

    $scope.getContent = function() {
        console.log('Editor content:', $scope.tinymceModel);
    };

    $scope.setContent = function() {
        $scope.tinymceModel = 'Time: ' + (new Date());
    };

    $scope.tinymceOptions = {
        plugins: 'advlist autolink link image code lists charmap print preview',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code',
        skin: 'lightgray',
        theme: 'modern'
    };
    $scope.DataService = dataFactory;
    $scope.Datas = [];
    for (var i = 0; i < 92; i++) {
        $scope.Datas.push("Customer " + i);
    }
    $scope.DataService.init($scope.Datas);

    $scope.DataService


    $scope.Url = "apps/views/Inbox.html";
    $scope.Inbox = function() {
        $scope.Url = "apps/views/Inbox.html";
    }
    $scope.Sent = function() {
        $scope.Url = "apps/views/Sent.html";
    }


})

.controller("ComposeController", function(
    $http, $scope, $sce, Services
) {
    $scope.DataSession = Services;
    // $scope.DataSession.Aun();
    $scope.DatasInput = {};

    $scope.DatasKategori = [];
    $scope.DatasTembusan = [];
    $scope.DatasPenerima = {};
    $scope.SelectedTembusan = {};
    $scope.DatasPejabat = [];
    $scope.SelectedKategori = {};
    $scope.Init = function() {

        var UrlKategori = "api/datas/read/ReadKategori.php";
        $http({
            method: "GET",
            url: UrlKategori
        }).then(function(response) {
            $scope.DatasKategori = response.data.records;
        }, function(error) {
            alert(error.data.message);
        })

        var Url = "api/datas/read/ReadPejabat.php";
        $http({
            method: "Get",
            url: Url
        }).then(
            function(response) {
                $scope.DatasPejabat = response.data.records;
            },
            function(error) {
                alert(error.data.message);
            }
        );

    }
    $scope.datasample;
    $scope.ShowBerkas = false;
    $scope.uploadedFile = function(element) {
        var reader = new FileReader();
        reader.onload = function(event) {
            $scope.$apply(function($scope) {
                $scope.files = element.files;
                $scope.datasample = event.target.result;
                if ($scope.datasample != undefined || $scope.datasample != "") {
                    $scope.ShowBerkas = true;
                }
                // //var datasource = src[1];

                // var file = new Blob([$scope.datasample], { type: 'application/pdf' });
                // var fileURL = URL.createObjectURL(file);
                // $scope.src = $sce.trustAsResourceUrl(fileURL);
            });
        }
        reader.readAsDataURL(element.files[0]);
    }

    $scope.PilihTembusan = function() {
        $scope.DatasTembusan.push(angular.copy($scope.SelectedTembusan));
        var index = $scope.DatasPejabat.indexOf(angular.copy($scope.SelectedTembusan));
        $scope.DatasPejabat.splice(index, 1);
        $scope.SelectedTembusan = {};
    }

    $scope.HapusTembusan = function(item) {
        var index = $scope.DatasTembusan.indexOf(item);
        $scope.DatasTembusan.splice(index, 1);
        $scope.DatasPejabat.push(item);
    }

    $scope.Simpan = function() {
        $http({
            url: "http://localhost/surat/api/datas/create/uploadBerkas.php", //or your add enquiry services
            method: "POST",
            processData: true,
            headers: { 'Content-Type': undefined },
            data: $scope.formdata,
            transformRequest: function(data) {
                var formData = new FormData();
                var file = $scope.files[0];
                //var data = $base64.encode(file);
                formData.append("file_upload", file); //pass the key name by which we will recive the file
                angular.forEach(data, function(value, key) {
                    formData.append(key, value);
                });

                return formData;
            }
        }).then(function(response) {
            if (response.data.message == "Success") {
                $scope.DatasInput.berkas = response.data.namefile;
                $scope.DatasInput.tujuan = $scope.DatasPenerima.idpejabat;
                $scope.DatasInput.NamaTujuan = $scope.DatasPenerima.nama_pengguna;
                $scope.DatasInput.StrukturalTujuan = $scope.DatasPenerima.nm_struktural;
                $scope.DatasInput.pengirim = $scope.DatasPenerima.nm_struktural;
            }
        }, function(error) {
            alert(error.data.message);
        })
    }
})

.controller("KategoriController", function(
    $scope,
    $http,
    DTOptionsBuilder,
    DTColumnBuilder,
    notificationService
) {
    $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType("full_numbers")
        .withOption("order", [1, "desc"]);
    // .withButtons([
    //     {
    //         extend: 'excelHtml5',
    //         customize: function (xlsx) {
    //             var sheet = xlsx.xl.worksheets['sheet1.xml'];

    //             // jQuery selector to add a border to the third row
    //             $('row c[r*="3"]', sheet).attr('s', '25');
    //             // jQuery selector to set the forth row's background gray
    //             $('row c[r*="4"]', sheet).attr('s', '5');
    //         }
    //     },
    //     {
    //         extend: "csvHtml5",
    //         fileName: "Data_Analysis",
    //         exportOptions: {
    //             columns: ':visible'
    //         },
    //         exportData: { decodeEntities: true }
    //     },
    //     {
    //         extend: "pdfHtml5",
    //         fileName: "Data_Analysis",
    //         title: "Data Analysis Report",
    //         exportOptions: {
    //             columns: ':visible'
    //         },
    //         exportData: { decodeEntities: true }
    //     },
    //     {
    //         extend: 'print',
    //         //text: 'Print current page',
    //         autoPrint: true,
    //         title: "Data Seleksi",
    //         exportOptions: {
    //             columns: ':visible'
    //         }
    //     }

    // ]);
    $scope.dtColumns = [
        DTColumnBuilder.newColumn("id").withTitle("ID"),
        DTColumnBuilder.newColumn("firstName").withTitle("First name"),
        DTColumnBuilder.newColumn("lastName").withTitle("Last name")
    ];
    $scope.DatasKategori = [];
    $scope.DataInput = {};
    $scope.Simpan = function() {
        var Data = $scope.DataInput;
        var InsertUrl = "api/datas/create/CreateKategori.php";
        $http({
            method: "POST",
            url: InsertUrl,
            data: Data
        }).then(
            function(response) {
                if (response.data.message > 0) {
                    $scope.DataInput.idkategori_surat = response.data.message;
                    $scope.DatasKategori.push(angular.copy($scope.DataInput));
                    notificationService.success("Successing text");
                }
            },
            function(error) {
                notificationService.error("Gagal Simpan");
            }
        );
    };

    $scope.Init = function() {
        var Kategoriurl = "api/datas/read/ReadKategori.php";
        $http({
            method: "Get",
            url: Kategoriurl
        }).then(
            function(response) {
                $scope.DatasKategori = response.data.records;
            },
            function(error) {
                alert(error.message);
            }
        );
    };
});