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
        if (confirm(ebook.lang.delete_list_confirm)) {
            $.ajax({
                method: 'post',
                url: $this.data('delete-url'),
                data: {
                    _method: 'delete'
                },
                cache: false
            }).done(function (res) {
                if (res.success === true) {
                    if (!res.redirect) {
                        $this.closest('.list-item').remove();
                        ebook.showNotify(res.message, 'success')
                    } else {
                        window.location.replace(res.redirect)
                    }
                } else {
                    ebook.showNotify(res.message)
                }
            }).fail(function (res) {
                ebook.showNotify(ebook.lang.unknow_error)
            })
        }
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
    }).on('click', '.on-lists-add', function (e) {
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
            }).done(function (res) {
                $list.html(res.content);
                $mustToggleClass.toggleClass('show');
            }).fail(function (e) {
                ebook.showNotify(ebook.lang.unknow_error)
            })
        } else {
            $mustToggleClass.removeClass('show');
        }
    }).on('click', '.on-archive, .on-add-to-list', function (e) {
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
        }).done(function (res) {
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
                $target.fadeOut('slow', function () {
                    $target.remove();
                });
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).fail(function (res) {
            ebook.showNotify(res.message)
        })
    }).on('click', '.on-unarchive', function (e) {
        e.preventDefault();
        var $this = $(this),
            $target = $this.closest('.col');
        if (confirm(ebook.lang.unarchive_confirm)) {
            $.ajax({
                method: 'post',
                url: ebook.base_url + '/library',
                data: {
                    story_id: $target.data('id')
                },
                cache: false
            }).done(function (res) {
                if (res.success === true) {
                    $target.fadeOut('slow', function () {
                        $target.remove();
                    })
                }
            }).fail(function (res) {
                ebook.showNotify(res.message)
            })
        }
    }).on('click', '.on-edit-list', function (e) {
        e.preventDefault();
        var $this = $(this),
            $target = $this.closest('.list-details');

        $target.addClass('list-editing');
    }).on('click', '.on-edit-list-submit', function (e) {
        e.preventDefault();
        var $this = $(this),
            $input = $('#listNameInput'),
            $target = $this.closest('.list-details'),
            value = $input.val().trim();

        if (value != $input.attr('value')) {
            $.ajax({
                method: 'post',
                url: $target.data('url'),
                data: {
                    list_name: $input.val()
                },
                cache: false
            }).done(function (res) {
                if (res.success === true) {
                    $input.attr('value', value);
                    $('#listName').text(value);
                    $target.removeClass('list-editing');
                } else {
                    ebook.showNotify(ebook.lang.unknow_error);
                }
            })
        } else {
            $target.removeClass('list-editing');
        }
    }).on('change', '#selectAll', function (e) {
        var $this = $(this),
            $stories = $('#listStories').find('[name="select[]"]');

        if (!$stories.length) {
            return false;
        }

        var $isNotChecked = $stories.filter(function (i, $e) {
            return !$e.checked;
        });


        var state = $this.prop('checked') && $isNotChecked.length > 0;

        $stories.map(function (i, $e) {
            $e.checked = state;
        })
        if ($this.prop('checked')) {
            $('#listControls').addClass('show');
            $('#selectedCount').text($stories.length);
        } else {
            $('#listControls').removeClass('show');
            $('#selectedCount').text('0');
        }
    }).on('change', '[name="select[]"]', function () {
        var $stories = $('#listStories').find('[name="select[]"]');

        var $isNotChecked = $stories.filter(function (i, $e) {
            return !$e.checked;
        });

        $('#selectAll').prop('checked', $isNotChecked.length === 0);

        if ($isNotChecked.length < $stories.length) {
            $('#listControls').addClass('show');
        } else {
            $('#listControls').removeClass('show');
        }
        $('#selectedCount').text($stories.length - $isNotChecked.length);
    }).on('click', '#post-submit', function () {
        $.ajax({
            method: 'post',
            url: ebook.base_url + '/chapter/' + $(this).data('id') + '/comment',
            data: {
                comment_text: $('#comment-text').val()
            },
            cache: false
        }).done(function (a) {
            var btnPost = $('#post-submit');
            $('#chapterComments').prepend(a);
            $('#comment-text').val('');
            btnPost.prop('disabled', true);
            $('#comment-text').css('height', '');
        });
    }).on('click', '.delete-comment', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $parent = $this.closest('.col-main').parent();
        $.ajax({
            url: ebook.base_url + '/chapter/comment/' + $this.data('id') + '/delete',
            method: 'post',
            data: {
                _method: 'delete',
            },
            cache: false
        }).done(function (res) {
            ebook.showNotify(res.message, 'success');
            if (res.success === true) {
                $parent.remove();
            }
        })
    }).on('click', '.on-reply-show', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $idReply = $(this).closest('.footer').find('.reply').first().find('.col-main').attr('data-id');
        $.ajax({
            url: $this.data('url'),
            method: 'get',
            data: { idReply: $idReply },
            cache: false
        }).done(function (a) {
            $this.text(ebook.lang.view_more_reply);
            $this.closest('.comment').find('.replies').prepend(a.content);
            if (a.key == 'no') {
                $this.remove();
            }
        })
    }).on('click', '.on-reply-click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $avatar = $('.add-comment').find('.avatar').find('img').attr('src');
        var $content = '<div class="comment-form d-flex reply-form"><div class="user-avatar"><div class="avatar avatar-md">'
                    + '<img src="' + $avatar +'" /></div></div><div class="comment-input flex-grow-1">'
                    + '<textarea name="text" class="form-control reply-text" rows="1"></textarea>'
                    + '<div class="d-flex justify-content-end mt-1"><button' 
                    + ' class="btn btn-sm btn-primary on-post ml-2 post-reply" disabled="">Post</button></div></div></div>';
        $('.reply-form').remove();
        $this.closest('.comment').find('.add-reply').append($content);
        $this.closest('.comment').find('.add-reply').find('.reply-text').focus();
    }).on('keyup', '.reply-text', function () {
        var $btnPost = $('.post-reply');
        if ($(this).val().length) {
            $btnPost.removeAttr('disabled');
        } else {
            $btnPost.prop('disabled', true);
        }
    }).on('click', '.post-reply', function () {
        var $this = $(this);
        var $reply = $(this).closest('.add-reply');
        var $text = $reply.find('.reply-text');
        $.ajax({
            method: 'post',
            url: ebook.base_url + '/comment/' + $reply.data('id') + '/reply',
            data: {
                comment_text: $text.val()
            },
            cache: false
        }).done(function (a) {
            $this.closest('.footer').find('.replies').append(a);
            $text.val('');
            $this.prop('disabled', true);
            $this.closest('.comment').find('.on-reply-show').html(ebook.lang.view_more_reply);
        });
    }).on('click', '.on-follow', function () {
        var $this = $(this);
        $.ajax({
            url: ebook.base_url + '/user/' + $this.data('id') + '/unfolow',
            method: 'post',
            cache: false,
        }).done(function (res) {
            if (res.success) {
                $this.removeClass('on-follow btn-success');
                $this.addClass('on-unfollow btn-light');
                $this.html('<i class="fa fa-user-plus"></i> ' + ebook.lang.unfollow);
            }
        })
    }).on('click', '.on-unfollow', function () {
        var $this = $(this);
        $.ajax({
            url: ebook.base_url + '/user/' + $this.data('id') + '/follow',
            method: 'post',
            cache: false,
        }).done(function (res) {
            if (res.success){
                $this.removeClass('on-unfollow btn-light');
                $this.addClass('on-follow btn-success');
                $this.html('<i class="fa fa-user-plus"></i> ' + ebook.lang.follow);
            }
        })
    }).on('click', '#notifications', function () {
        var notify = $(this).find('span.notify');
        if (notify.hasClass('text-danger')) {
            notify.removeClass('text-danger');
            $.ajax({
                url: ebook.base_url + '/notifications/read/' + $(this).data('id'),
                method: 'post',
                cache: false,
            });
        }
    })
    $('#removeFromList').on('click', function () {
        var $this = $(this),
            $stories = $('#listStories').find('[name="select[]"]');

        var $isChecked = $stories.filter(function (i, $e) {
            return $e.checked;
        });

        var select_ids = $isChecked.map(function (i, $e) { return $e.value }).toArray();

        if ($isChecked.length) {
            $.ajax({
                method: 'post',
                url: $this.data('url'),
                data: {
                    select: select_ids
                },
                cache: false
            }).done(function (res) {
                if (res.success) {
                    $isChecked.closest('.story').remove();
                    $('#selectedCount').text('0');
                    $('#listControls').removeClass('show');
                }
            }).fail(function () {
                ebook.showNotify()
            })
        }
    });
    $('#comment-text').focus(function () {
        var btnPost = $('#post-submit').parent();
        if (btnPost.hasClass('d-none')) {
            $(this).css('height', '100px');
            btnPost.removeClass('d-none');
            btnPost.addClass('d-flex');
        }
    }).blur(function () {
        var btnPost = $('#post-submit').parent();
        if ($(this).val().length == 0) {
            if (btnPost.hasClass('d-flex')) {
                $(this).css('height', '');
                btnPost.removeClass('d-flex');
                btnPost.addClass('d-none');
            }
        }
    }).keyup(function () {
        var btnPost = $('#post-submit');
        if ($(this).val().length) {
            btnPost.removeAttr('disabled');
        } else {
            btnPost.prop('disabled', true);
        }
    });
    $('#storyForm').on('submit', function (e) {
        e.preventDefault();
        var $this = $(this),
            $submit = $this.find('[type="submit"]');
        $.ajax({
            method: 'post',
            url: $this.attr('action'),
            data: new FormData($this[0]),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $this.find('input, button, select, textarea').each(function() {
                    if ($(this).is(':disabled')) {
                        $(this).data('disabled', true);
                    }
                    $(this).attr('disabled', true);
                });
                $submit.data('html', $submit.html()).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
                        + ebook.lang.loading
                )
            },
            complete: function() {
                $this.find('input, button, select, textarea').each(function() {
                    if ($(this).data('disabled') === true) {
                        $(this).attr('disabled', true);
                    }
                    $(this).removeAttr('disabled');
                })
            }
        }).done(function (res) {
            if (res && res.success === true) {
                if (res.action == 'create') {
                    window.location.replace(res.redirectTo);
                } else {
                    ebook.showNotify(ebook.lang.update_success, 'success');
                }
            }
        }).fail(function (res) {
            if (res && res.status === 422) {
                var errors = res.responseJSON.errors;
                for (var a in errors) {
                    for (var b in errors[a]) {
                        ebook.showNotify(errors[a][b])
                        break;
                    }
                    break;
                }
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).always(function () {
            $submit.html($submit.data('html'))
        });
    });
    $('#chapterForm').on('submit', function (e) {
        e.preventDefault();
    }).on('click', '.on-save-chapter', function (e) {
        e.preventDefault();
        var $this = $(this),
            $form = $this.closest('form');
        var formData = new FormData($form[0]);

        formData.append('publish', $this.data('publish'));
        $.ajax({
            method: 'post',
            url: $this.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $this.find('input, button, select, textarea').each(function() {
                    if ($(this).is(':disabled')) {
                        $(this).data('disabled', true);
                    }
                    $(this).prop('disabled', true);
                });
                $this.data('html', $this.html()).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
                        + ebook.lang.loading
                )
            },
            complete: function() {
                $this.find('input, button, select, textarea').each(function() {
                    $(this).removeAttr('disabled');
                    if ($(this).data('disabled') === true) {
                        $(this).prop('disabled', true);
                    }
                })
            }
        }).done(function (res) {
            if (res && res.success === true) {
                ebook.showNotify(ebook.lang.update_success, 'success');
            }
        }).fail(function (res) {
            if (res && res.status === 422) {
                var errors = res.responseJSON.errors;
                for (var a in errors) {
                    for (var b in errors[a]) {
                        ebook.showNotify(errors[a][b])
                        break;
                    }
                    break;
                }
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).always(function () {
            $this.html($this.data('html'))
        })
    });
    $('.on-create-chapter').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.prop('disabled', true);
        $.ajax({
            method: 'post',
            url: $this.data('url'),
            cache: false
        }).done(function (res) {
            if (res && res.success === true) {
                window.location.replace(res.redirectTo)
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).fail(function () {
            ebook.showNotify(ebook.lang.unknow_error)
        }).always(function () {
            $this.prop('disabled', false);
        })
    });
    $('.on-delete-story').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            method: 'post',
            url: $this.data('url'),
            data: {
                _method: 'delete'
            },
            cache: false
        }).done(function (res) {
            if (res && res.success) {
                window.location.replace(res.redirectTo);
                $this.closest('.story').remove()
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).fail(function () {
            ebook.showNotify(ebook.lang.unknow_error)
        })
    });
    $('.on-unpublish-story').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            method: 'post',
            url: $this.data('url'),
            data: {
                _method: 'patch'
            },
            cache: false
        }).done(function (res) {
            if (res && res.success) {
                ebook.showNotify(ebook.lang.update_success, 'success')
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).fail(function () {
            ebook.showNotify(ebook.lang.unknow_error)
        })
    });
    $('.on-delete-chapter').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            method: 'post',
            url: $this.data('url'),
            data: {
                _method: 'delete'
            },
            cache: false
        }).done(function (res) {
            if (res && res.success) {
                ebook.showNotify(ebook.lang.update_success, 'success');
                $this.closest('.list-group-item').remove()
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).fail(function () {
            ebook.showNotify(ebook.lang.unknow_error)
        })
    });
    $('.on-unpublish-chapter').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            method: 'post',
            url: $this.data('url'),
            data: {
                _method: 'patch'
            },
            cache: false
        }).done(function (res) {
            if (res && res.success) {
                ebook.showNotify(ebook.lang.update_success, 'success');
                $this.closest('.list-group-item').find('status').text(ebook.lang.draft)
            } else {
                ebook.showNotify(ebook.lang.unknow_error)
            }
        }).fail(function () {
            ebook.showNotify(ebook.lang.unknow_error)
        })
    });
    $('#logout').on('click', function (e) {
        e.preventDefault();
        $('#logoutForm').submit()
    });
    $('#storyCover').on('change', function() {
        var $this = $(this);

        ebook.readImage($this[0].files[0], $this.closest('.thumbnail'));
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
    },
    readImage: function (file, $target) {
        if (file && file.name.match(/\.(jpe?|pn)g$/)) {
            var reader = new FileReader();
            reader.onload = function(evt) {
                $target.css({
                    'background-size': 'cover',
                    'background-image': 'url(' + evt.target.result + ')'
                });
            };
            reader.readAsDataURL(file);
        }
    }
});
