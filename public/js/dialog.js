async function saveData(title, form, url, resposeSuccess, image = null) {

    var form_data = new FormData($('#' + form)[0]);

    console.log(form_data)
    swal({
        title: title,
        text: "Apa kamu yakin ?",
        icon: "info",
        buttons: true,
        primariMode: true,
    })
        .then(async (res) => {
            if (res) {
                if (image){
                    if ($('#'+image).val()) {
                        let image1 = await handleImageUpload($('#'+image));
                        form_data.append('profile', image1, image1.name);
                    }
                }
                $.ajax({
                    type: "POST",
                    data: form_data,
                    url: url ?? window.location.pathname,
                    async: true,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': "application/json"
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data);

                        if (xhr.status === 200) {
                            swal("Berhasil", {
                                icon: "success",
                                buttons: false,
                                timer: 1000
                            }).then((dat) => {
                                if (resposeSuccess) {
                                    resposeSuccess(data)
                                } else {
                                    window.location.reload()
                                }
                            });
                        } else {
                            swal(data['msg'])
                        }
                        console.log(data);
                    },
                    xhr: function() {
                        $('#progressbar').remove();
                        $('#'+form).append(' <div id="progressbar" class="progress mt-2">\n' +
                            '                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>\n' +
                            '                            </div>')
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                //Do something with upload progress here
                                // console.log(percentComplete)
                                $('#progressbar div').attr('style',"width:"+percentComplete+'%').html(parseInt(percentComplete)+'%')
                                if (percentComplete === 100){
                                    $('#progressbar div').addClass('bg-success')
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    // uploadProgress: function(event, position, total, percentComplete){
                    //     var percentVal = percentComplete + '%';
                    //     console.log(percentVal);
                    //     console.log(percentVal);
                    //
                    // },
                    complete: function (xhr, textStatus) {
                        $('#progressbar').remove();
                    },
                    error: function (error, xhr, textStatus) {
                        // console.log("LOG ERROR", error.responseJSON.errors);
                        // console.log("LOG ERROR", error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0]);
                        $('#progressbar div').removeClass('bg-success').addClass('bg-danger');
                        console.log(error);
                        console.log(textStatus);
                        swal(JSON.parse(error.responseText).errors ? JSON.parse(error.responseText).errors[Object.keys(JSON.parse(error.responseText).errors)[0]][0] : JSON.parse(error.responseText)?.message ? JSON.parse(error.responseText).message : JSON.parse(error.responseText).msg ? JSON.parse(error.responseText).msg : error.responseJSON['msg'] )
                        // swal(error.responseText ? JSON.parse(error.responseText).message : error.responseJSON['msg'] )
                    }
                })
            }
        });
    return false;
}

function saveDataObjectFormData(title, form_data, url, resposeSuccess) {
    console.log('asdasd', form_data)
    swal({
        title: title,
        text: "Apa kamu yakin ?",
        icon: "info",
        buttons: true,
        primariMode: true,
    })
        .then((res) => {
            if (res) {
                $.ajax({
                    type: "POST",
                    data: form_data,
                    url: url ?? window.location.pathname,
                    async: true,
                    // processData: false,
                    // contentType: false,
                    headers: {
                        'Accept': "application/json"
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data);

                        if (xhr.status === 200) {
                            swal("Data Updated ", {
                                icon: "success",
                                buttons: false,
                                timer: 1000
                            }).then((dat) => {
                                if (resposeSuccess) {
                                    resposeSuccess(data)
                                } else {
                                    window.location.reload()
                                }
                            });
                        } else {
                            swal(data['msg'])
                        }
                        console.log(data);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                        console.log(textStatus);
                    },
                    error: function (error, xhr, textStatus) {
                        // console.log("LOG ERROR", error.responseJSON.errors);
                        // console.log("LOG ERROR", error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0]);
                        console.log(xhr.status);
                        console.log(textStatus);
                        console.log(error.responseJSON);
                        swal(JSON.parse(error.responseText).errors ? JSON.parse(error.responseText).errors[Object.keys(JSON.parse(error.responseText).errors)[0]][0] : JSON.parse(error.responseText)?.message ? JSON.parse(error.responseText).message : error.responseJSON['msg'] )

                        // swal(error.responseJSON.errors ? error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0] : error.responseJSON['message'] ? error.responseJSON['message'] : error.responseJSON['msg'] )

                    }
                })
            }
        });
    return false;
}

function saveDataAjaxWImage(title, form, form_data, url, resposeSuccess) {
    var dataForm = form_data['form_data'];
    console.log(form_data);
    if (form_data['image']){
        $.each(form_data['image'], async function (k,v) {
            if ($('#'+form+' #'+v).val()) {
                let icon = await handleImageUpload($('#'+v));
                dataForm.append(v, icon, icon.name);
            }
        })
    }
    console.log(dataForm.get('icon'));
    swal({
        title: title,
        text: "Apa kamu yakin ?",
        icon: "info",
        buttons: true,
        primariMode: true,
    })
        .then((res) => {
            if (res) {
                $.ajax({
                    type: "POST",
                    data: dataForm,
                    url: url ?? window.location.pathname,
                    async: true,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': "application/json"
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data);

                        if (xhr.status === 200) {
                            swal("Data created ", {
                                icon: "success",
                                buttons: false,
                                timer: 1000
                            }).then((dat) => {
                                if (resposeSuccess) {
                                    resposeSuccess(data)
                                } else {
                                    window.location.reload()
                                }
                            });
                        } else {
                            swal(data['msg'])
                        }
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                        console.log(textStatus);
                    },
                    error: function (error, xhr, textStatus) {
                        // console.log("LOG ERROR", error.responseJSON.errors);
                        // console.log("LOG ERROR", error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0]);
                        $('#progressbar div').removeClass('bg-success').addClass('bg-danger');
                        console.log(error);
                        console.log(textStatus);
                        swal(JSON.parse(error.responseText).errors ? JSON.parse(error.responseText).errors[Object.keys(JSON.parse(error.responseText).errors)[0]][0] : JSON.parse(error.responseText)?.message ? JSON.parse(error.responseText).message : JSON.parse(error.responseText).msg ? JSON.parse(error.responseText).msg : error.responseJSON['msg'] )

                    }
                })
            }
        });
    return false;

}

function deleteData(text, url,data, resposeSuccess) {

    console.log(data);
    swal({
        title: 'Hapus Data',
        text: "Apa kamu yakin menghapus data " + text + " ?",
        icon: "info",
        buttons: true,
        dangerMode: true,
    })
        .then((res) => {
            if (res) {
                $.ajax({
                    type: "POST",
                    data: data,
                    url: url,
                    async: true,
                    // processData: false,
                    // contentType: false,
                    headers: {
                        'Accept': "application/json"
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data);

                        if (xhr.status === 200) {
                            swal("Data Deleted ", {
                                icon: "success",
                                buttons: false,
                                timer: 1000
                            }).then((dat) => {
                                if (resposeSuccess) {
                                    resposeSuccess(data)
                                } else {
                                    window.location.reload()
                                }
                            });
                        } else {
                            swal(data['msg'])
                        }
                        console.log(data);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                        console.log(textStatus);
                    },
                    error: function (error, xhr, textStatus) {
                        // console.log("LOG ERROR", error.responseJSON.errors);
                        // console.log("LOG ERROR", error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0]);
                        // console.log(xhr.status);
                        // console.log(textStatus);
                        // console.log(error.responseJSON);
                        // swal(error.responseJSON.errors ? error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0] : error.responseJSON['message'] ? error.responseJSON['message'] : error.responseJSON['msg'] )
                        console.log();
                        console.log(xhr);
                        console.log(textStatus);
                        // swal(error.responseJSON.errors ? error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0] : error.responseJSON['message'] ? error.responseJSON['message'] : error.responseJSON['msg'] )
                        swal(error.responseText ? JSON.parse(error.responseText).message : error.responseJSON['msg'] )
                    }
                })
            }
        });
    return false;
}

function getSelect(id, url, nameValue = 'name', idValue, text = null) {
    var select = $('#' + id);
    select.empty();
    if (text){
        select.append('<option value="" selected>'+text+'</option>')
    }else {
        select.append('<option value="" disabled selected>Pilih Data</option>')
    }
    $.get(url, function (data) {
        $.each(data, function (key, value) {
            if (idValue === value['id']) {
                select.append('<option value="' + value['id'] + '" selected>' + value[nameValue] + '</option>')
            } else {
                select.append('<option value="' + value['id'] + '">' + value[nameValue] + '</option>')
            }
        })
    })
}

function currency(field) {
    $('#' + field).on({
        keyup: function () {
            formatCurrency($(this));
        },
        blur: function () {
            formatCurrency($(this), "blur");
        }
    });
}

function setImgDropify(img,text ='Masukkan Image Item',   file = null, height = 400) {
    img = $('#' + img).dropify({
        messages: {
            'default': text,
            'replace': 'Drag and drop or click to replace',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    });
    img = img.data('dropify');
    img.resetPreview();
    img.clearElement();

    if (file) {
        img.settings.defaultFile = file;
        img.destroy();
        img.init();
    }
    $('.dropify-wrapper').height(height).width(300);

}
