$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        loop: true,
        autoplay: true,
        dots: false,
        margin: 30,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1.5
            },
            992: {
                items: 2.5,
                nav: true
            },
            1366: {
                items: 2.5,
                nav: true
            }
        }
    });
    $(document).on('click', '.on-story-preview', function () {
        var $this = $(this),
            story_url = $this.closest('.story').data('url');
        $.ajax({
            url: story_url,
            method: 'GET',
            cache: false,
            dataType: 'html'
        }).done(function (res) {
            $('#storyPreviewModal .modal-body').html(res);
            $('#storyPreviewModal').modal('show');
        })
        return false;
    }).on('click', '#new-tab', function () {
        var $this = $(this),
            $target = $($this.attr('href')),
            story_url = $this.data('url');
        if (!!$target.text().trim()) {
            return;
        }
        $.ajax({
            url: story_url,
            method: 'GET',
            cache: false,
            dataType: 'html'
        }).done(function (res) {
            $target.html(res);
        })
    }).on('submit', '.on-create-list', function (e) {
        e.preventDefault();
        var $this = $(this),
            $input = $this.find('[name="list_name"]');

        $input.removeClass('is-invalid');
        $.ajax({
            method: 'post',
            url: $this.attr('action'),
            data: $this.serialize(),
            cache: false,
            dataType: 'json'
        }).done(function (res) {
            if (res.success === true) {
                if (res.source === 'library') {
                    // load from library
                    $('#readingLists').prepend(res.data);
                    $this.closest('.modal').modal('hide');
                } else {
                    // load from save story
                    $this.closest('.lists').find('.dropdown-divider').before(res.data);
                }
                $input.val('');
                ebook.showNotify(res.message, 'success')
            } else {
                ebook.showNotify(res.message, 'success')
            }
        }).fail(function (res) {
            if (res.status === 422) {
                var message = res.responseJSON.errors.list_name[0];
                $input.addClass('is-invalid');
                $input.parent().find('.invalid-feedback').text(message)
            } else {
                var message = res.responseJSON.message;
                ebook.showNotify(message)
            }
        })
    }).on('click', '.on-delete-list', function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            method: 'post',
            url: $this.data('delete-url'),
            data: {
                _method: 'delete'
            },
            cache: false,
            dataType: 'json'
        }).done(function (res) {
            if (res.success === true) {
                $this.closest('.list-item').remove();
                ebook.showNotify(res.message, 'success')
            } else {
                ebook.showNotify(res.message)
            }
        }).fail(function (res) {
            ebook.showNotify(ebook.lang.unknow_error)
        })
    }).on('click', '.on-show-more', function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            method: 'get',
            url: $this.data('url'),
            cache: false,
            dataType: 'json'
        }).done(function (res) {
            console.log(res);
            $($this.data('target')).append(res.content);
            if (!!res.next_page_url) {
                $this.data('url', res.next_page_url)
            } else {
                $this.fadeOut().remove();
            }
        }).fail(function () {
            ebook.showNotify(ebook.lang.unknow_error);
        })
    }).on('click', '.on-lists-add', function(e) {
        e.preventDefault();

        var $this = $(this),
            $target = $this.closest('.button-lists-add'),
            $list = $target.find('.lists'),
            $mustToggleClass = $($target).add($list);

        if (!$target.hasClass('show')) {
            $.ajax({
                method: 'get',
                url: ebook.base_url + '/ajax/lists',
                data: {
                    story_id: $target.data('id')
                },
                cache: false
            }).done(function(res) {
                $list.html(res.content);
                $mustToggleClass.toggleClass('show');
            }).fail(function (e) {
                ebook.showNotify(ebook.lang.unknow_error)
            })
        } else {
            $mustToggleClass.removeClass('show');
        }
    }).on('click', '.on-archive, .on-add-to-list', function(e) {
        e.preventDefault();
        var $this = $(this),
            $target = $this.closest('.button-lists-add'),
            do_archive = $this.hasClass('on-archive');

        $.ajax({
            method: 'post',
            url: ebook.base_url + (do_archive ? '/library' : '/lists/' + $this.data('id') + '/stories'),
            data: {
                story_id: $target.data('id')
            },
            cache: false
        }).done(function(res) {
            if (res.success === true) {
                if (res.action == 'detach') {
                    $this.children().last().remove()
                } else {
                    $this.append($('<i/>').addClass('fa fa-check-circle-o saved'))
                }
            }
        }).fail(function (res) {
            ebook.showNotify(res.message)
        })
    }).on('mouseleave', '.on-mouse-out', function () {
        $(this).find('.show').removeClass('show');
    }).on('click', '.on-archive-status', function (e) {
        e.preventDefault();
        var $this = $(this),
            $target = $this.closest('.col');
        
        $.ajax({
            method: 'post',
            url: ebook.base_url + '/archive',
            data: {
                story_id: $target.data('id')
            },
            cache: false
        }).done(function (res) {
            if (res.success === true) {
                $target.fadeOut('slow', function() {
                    $target.remove();
                });
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).fail(function (res) {
            ebook.showNotify(res.message)
        })
    }).on('click', '.on-unarchive', function(e) {
        e.preventDefault();
        var $this = $(this),
            $target = $this.closest('.col');

        $.ajax({
            method: 'post',
            url: ebook.base_url + '/library',
            data: {
                story_id: $target.data('id')
            },
            cache: false
        }).done(function(res) {
            if (res.success === true) {
                $target.fadeOut('slow', function() {
                    $target.remove();
                })
            }
        }).fail(function (res) {
            ebook.showNotify(res.message)
        })
    });
    $('#logout').on('click', function (e) {
        e.preventDefault();
        $('#logoutForm').submit()
    })
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.extend(true, ebook, {
    showNotify: function (message, type = 'warning') {
        $.notify({
            message: message
        }, {
            type: type,
            z_index: 1051,
            placement: {
                from: 'bottom',
                align: 'left',
            }
        })
    }
});
