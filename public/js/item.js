let image1, image2, image3;
var s_provinsi, s_kota, s_tipe, s_posisi;

var center = {
  lat: -7.57797433093528,
  lng: 110.80924297710521,
};

function onTabChange() {
  $("#pills-tab").on("shown.bs.tab", function (e) {
    if (e.target.id === "pills-peta-tab") {
      // generateMap("main-map");
      generateGoogleMapData().then((r) => {});
    }
  });
}

function onTabDetailChange() {
  $("#pills-tab-detail").on("shown.bs.tab", function (e) {
    if (e.target.id === "pills-maps-tab-detail") {
      let id = $("#d-id").val();
      // generateSingleMap("map-detail", id);
    }
  });
}

$(document).on("change", "#province", function () {
  let id = $(this).val();
  getSelect(
    "city",
    "/data/province/" + id + "/city",
    "name",
    null,
    "Pilih Kota"
  );
});

$(document).on("change", "#f-provinsi", function (ev) {
  s_provinsi = $(this).val();
  if (s_provinsi === "") {
    getSelect("f-kota", "/data/city", "name", null, "Semua Kota");
  } else {
    getSelect(
      "f-kota",
      "/data/province/" + s_provinsi + "/city",
      "name",
      null,
      "Semua Kota"
    );
  }
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  pillSearch("provinsi", text);
  datatableItem();
  generateGoogleMapData().then((r) => {});
});
$(document).on("change", "#f-kota", function (ev) {
  s_kota = $(this).val();
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  pillSearch("kota", text);
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

$(document).on("change", "#f-tipe", function (ev) {
  s_tipe = $(this).val();
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  pillSearch("tipe", text);
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

$(document).on("change", "#f-posisi", function (ev) {
  s_posisi = $(this).val();
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  pillSearch("posisi", text);
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

function pillSearch(a, text) {
  let pill = $("#pillSearch");
  let child = document.getElementById("pill" + a);
  if (child) {
    $("#pill" + a + " #text").html(text);
  } else {
    pill.append(
      '<span class="badge bg-primary me-2 " id="pill' +
        a +
        '" style="border-radius: 200px; align-items: center"><span id="text">' +
        text +
        '</span>  <a role="button" id="removePill" data-id="' +
        a +
        '"><i class="material-symbols-outlined" style="font-size: 12px">close</i></a></span>'
    );
  }
  //
}

$(document).on("change", ".selectType", function (ev) {
  var text = $(this).find(":selected").text();
  changeSelectType(text);
});

function changeSelectType(text) {
  // $('#form #qty').removeAttr('readonly');
  $("#form #qty").val("1");
  if (text.toLowerCase().includes("led banneer") == false) {
    // $('#form #qty').val('1');
    // $('#form #qty').attr('readonly', '').val('1');
  }
}

$(document).on("click", "#removePill", function () {
  let id = $(this).data("id");
  let parent = document.getElementById("pillSearch");
  let child = document.getElementById("pill" + id);
  parent.removeChild(child);
  $("#f-" + id).val("");
  window["s_" + id] = "";
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

$(document).on("click", "#addData, #editData", async function () {
  let id = $(this).data("id");
  let data = $(this).data("row");
  $("#form #id").val(id);
  $('#form input[type="text"]').val("");
  $('#form input[type="number"]').val("");
  // $('#form #qty').val("1").attr('readonly','');
  $("#form #qty").val("1");
  $("#form #side").val("1");
  $("#form #trafic").val("0");
  $("#form select").val("");
  let fileImg1 = null,
    fileImg2 = null,
    fileImg3 = null,
    prov = null,
    vendor = null;
  $("#city").empty();
  if (id) {
    let url = await getUrl(data.id);
    changeSelectType(data.type.name);
    prov = data.city.province.id;
    vendor = data.vendor_all?.id;
    $("#form #name").val(data.name);
    $("#form #address").val(data.address);
    $("#form #location").val(data.location);
    $("#form #url_show").val(data.url_show);
    $("#form #urlstreetview").val(url);
    $("#form #latlong").val(data.latitude + ", " + data.longitude);
    $("#form #position").val(data.position);
    $("#form #type").val(data.type.id);
    $("#form #qty").val(data.qty);
    $("#form #side").val(data.side);
    $("#form #trafic").val(data.trafic);
    $("#form #height").val(data.height);
    $("#form #width").val(data.width);
    getSelect(
      "city",
      "/data/province/" + data.city.province.id + "/city",
      "name",
      data.city.id
    );

    fileImg1 = data.image1;
    fileImg2 = data.image2;
    fileImg3 = data.image3;
  }
  getSelect("province", "/data/province", "name", prov, "Pilih Provinsi");
  getSelect("vendor", "/admin/vendor/all", "name", vendor, "Pilih Vendor");

  setImgDropify("image1", null, fileImg1);
  setImgDropify("image2", null, fileImg2);
  setImgDropify("image3", null, fileImg3);
  $("#modaltambahtitik").modal({ backdrop: "static", keyboard: false });
  $("#modaltambahtitik").modal("show");
});

$("#modaldetail").on("shown.bs.modal", function () {
  $("#pills-detail-tab").tab("show");
  onTabDetailChange();
});

$("#modaldetail").on("show.bs.modal", function () {
  $("#pills-detail-tab").tab("show");
});

$("#modaldetail").on("hidden.bs.modal", function () {});

$(document).on("click", "#detailData", async function () {
  let data = $(this).data("row");
  let id = data.id;
  await generateSingleGoogleMapData(data);
  $("#simple-modal-detail").modal("show");
  //
  // let url = await getUrl(data.id);
  //
  // $('#d-id').val(data.id);
  // $('#d-name').html(data.name);
  // $('#d-provinsi').val(data.city?.province?.name);
  // $('#d-kota').val(data.city?.name);
  // $('#d-alamat').val(data.address);
  // $('#d-lokasi').val(data.location);
  // $('#d-tipe').val(data.type?.name);
  // $('#d-urlstreetview').val(url);
  // $('#d-latlong').val(data.latitude+', '+data.longitude);
  // $('#d-posisi').val(data.position);
  // $('#d-panjang').val(data.height);
  // $('#d-lebar').val(data.width);
  // $('#d-Vendor').val(data.vendor?.name);
  // $('#openTapGmap').removeAttr('href').attr('href', data.url_show);
  // $('#showImg1').empty();
  // $('#showImg2').empty();
  // $('#showImg3').empty();
  // $('#downlodShowImg1').removeAttr('href').removeAttr('download');
  // $('#downlodShowImg2').removeAttr('href').removeAttr('download');
  // $('#downlodShowImg2').removeAttr('href').removeAttr('download');
  // if (data.image1) {
  //     $('#showImg1').html('<img src="' + data.image1 + '"  alt=""/>')
  //     $('#downlodShowImg1').attr('href',data.image1 ).attr('download','image1')
  // }
  // if (data.image2) {
  //     $('#showImg2').html('<img src="' + data.image2 + '"  alt=""/>')
  //     $('#downlodShowImg2').attr('href',data.image2 ).attr('download','image2')
  // }
  // if (data.image3) {
  //     $('#showImg3').html('<img src="' + data.image3 + '"  alt=""/>')
  //     $('#downlodShowImg3').attr('href',data.image3 ).attr('download','image3')
  // }
  // showStreetView(url);
  // $("#modaldetail").modal("show");
});

function datatableItem() {
  let formData = {
    province: s_provinsi,
    city: s_kota,
    type: s_tipe,
    position: s_posisi,
  };
  let stringData = JSON.stringify(formData);
  var url = "/data/item/datatable";
  $("#table_id").DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: url,
      data: formData,
    },
    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
      // debugger;
      var numStart = this.fnPagingInfo().iStart;
      var index = numStart + iDisplayIndexFull + 1;
      // var index = iDisplayIndexFull + 1;
      $("td:first", nRow).html(index);
      return nRow;
    },
    columns: [
      {
        className: "",
        orderable: false,
        defaultContent: "",
        searchable: false,
      },
      {
        data: "city.name",
        name: "city.name",
      },
      {
        data: "name",
        name: "name",
        render: function (data) {
          return data ?? "-";
        },
      },
      {
        data: "address",
        name: "address",
      },
      {
        data: "vendor_all.name",
        name: "vendorAll.name",
        render: function (data, type, row) {
          let delet = "";
          if (row.vendor_all?.deleted_at) {
            delet = '<br><span style="color: red">( deleted )</span>';
          }
          return data + " " + delet;
        },
      },
      {
        data: "height",
        name: "height",
      },
      {
        data: "width",
        name: "width",
      },
      {
        data: "type.name",
        name: "type.name",
      },
      {
        data: "position",
        name: "position",
      },
      {
        data: "created_by.nama",
        name: "createdBy.nama",
      },
      {
        data: "last_update.nama",
        name: "lastUpdate.nama",
        render: function (data, type, row) {
          var update = data ?? "-";
          return (
            '<div class="d-flex">' +
            '<span class="me-2">' +
            update +
            "</span>" +
            '<div><a class="btn-sm btn-danger-soft" data-name="' +
            row.name +
            '" data-id="' +
            row.id +
            '" id="btnHistory" ><i class="material-symbols-outlined" style="font-size: 12px">history</i></a></div></div>'
          );
        },
      },
      {
        data: "id",
        searchable: false,
        render: function (data, type, row) {
          delete row["url"];
          let role = $('meta[name="role"]').attr("content");
          let string = JSON.stringify(row);
          var dlt = "";
          if (role == "pimpinan") {
            dlt =
              "<a class='btn-danger-soft sml rnd  me-1' data-id='" +
              data +
              "' data-row='" +
              string +
              "' id='deteleData'> <i class='material-symbols-outlined menu-icon  me-1'>delete</i></a>";
          }
          return (
            "<div class='d-flex'>" +
            "       <a class='btn-utama-soft sml rnd me-1' data-row='" +
            string +
            "' id='detailData'> <i class='material-symbols-outlined menu-icon'>map</i></a>\n" +
            "       <a class='btn-success-soft sml rnd me-1' data-id='" +
            data +
            "' data-row='" +
            string +
            "' id='editData'> <i class='material-symbols-outlined  me-1 menu-icon'>edit</i></a>" +
            dlt +
            "</div>"
          );
        },
      },
    ],
  });
}

$(document).on("click", "#deteleData", function () {
  let row = $(this).data("row");
  let id = row.id;
  let type = row.type.name;
  let area = row.city.name;
  let address = row.address;
  let location = row.location;
  let name = type + " " + area + ", " + address + " ( " + location + " )";
  let data = {
    _token: $('meta[name="_token"]').attr("content"),
  };
  deleteData(name, "/data/item/delete/" + id, data, datatableItem);
  return false;
});

function datatableItemPresence() {
  let formData = {
    province: s_provinsi,
    city: s_kota,
    type: s_tipe,
    position: s_posisi,
  };
  let stringData = JSON.stringify(formData);
  var url = "/data/item/datatable";
  $("#table_presence").DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: url,
      data: formData,
    },
    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
      // debugger;
      var numStart = this.fnPagingInfo().iStart;
      var index = numStart + iDisplayIndexFull + 1;
      // var index = iDisplayIndexFull + 1;
      $("td:first", nRow).html(index);
      return nRow;
    },
    columns: [
      {
        className: "",
        orderable: false,
        defaultContent: "",
      },
      {
        data: "city.name",
        name: "city.name",
      },
      {
        data: "name",
        name: "name",
      },
      {
        data: "address",
        name: "address",
      },
      {
        data: "height",
        name: "height",
      },
      {
        data: "width",
        name: "width",
      },
      {
        data: "type.name",
        name: "type.name",
      },
      {
        data: "qty",
        name: "qty",
      },
      {
        data: "side",
        name: "side",
      },
      {
        data: "position",
        name: "position",
      },
      {
        data: "id",
        render: function (data, type, row) {
          delete row["url"];
          let string = JSON.stringify(row);
          return (
            "<div class='d-flex'><a class='btn-utama-soft sml rnd me-1' data-row='" +
            string +
            "'  \n" +
            "                                                  id='detailData'> <i class='material-symbols-outlined menu-icon'>map</i></a>\n" +
            "                                </div>"
          );
        },
      },
    ],
  });
}

function saveItem() {
  let form = $("#form");
  form.submit(async function (e) {
    e.preventDefault(e);
    let formData = new FormData(this);
    // if ($('#image1').val()) {
    //     let img = await handleImageUpload($('#image1'));
    //     formData.append('image1', img, img.name)
    // }
    // if ($('#image2').val()) {
    //     let img = await handleImageUpload($('#image2'));
    //     formData.append('image2', img, img.name)
    // }
    // if ($('#image3').val()) {
    //     let img = await handleImageUpload($('#image3'));
    //     formData.append('image3', img, img.name)
    // }
    let data = {
      form_data: formData,
      image: {
        image1: "image1",
        image2: "image2",
        image3: "image3",
      },
    };
    saveDataAjaxWImage(
      "Simpan Data",
      "form",
      data,
      "/data/item/post-item",
      afterSave
    );
    return false;
  });
}

function afterSave() {
  $("#modaltambahtitik").modal("hide");
  datatableItem();
}

$(document).on("click", "#btnHistory", function () {
  var id = $(this).data("id");
  var name = $(this).data("name");
  let tabel = $("#bodyHistory");
  tabel.empty();
  $.get("/admin/history/" + id, function (data) {
    if (data.length > 0) {
      $.each(data, function (k, v) {
        let string =
          k === parseInt(data.length - 1)
            ? v.user.nama + " ( create )"
            : v.user.nama;
        moment.locale("id");

        tabel.append(
          "<tr>" +
            "             <td>" +
            parseInt(k + 1) +
            "</td>" +
            "             <td>" +
            string +
            "</td>" +
            "             <td>" +
            moment(v.created_at).format("LLLL") +
            "</td>" +
            "         </tr>"
        );
      });
    }
  });

  $("#modalHistory #titleHistory").html(name);
  $("#modalHistory").modal("show");
});

async function showStreetView(url) {
  var panel = $("#panel-street");
  panel.empty();

  // var url = await getUrl(id);
  // if (url) {
  panel.html(url);
  let frame = $("#panel-street iframe")[0];
  if (frame) {
    $("#panel-street iframe").removeAttr("width").attr("width", "100%");
  }
  // }
}

async function getUrl(id) {
  let url;
  await $.get("/data/item/url-street-view/" + id, function (data) {
    url = data;
  });
  return url;
}
