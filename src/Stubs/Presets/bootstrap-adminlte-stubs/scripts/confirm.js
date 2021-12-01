/**
 * @example
 * <a href="{{ route('future.pages.settings.users.destroy', $user->getKey()) }}"
 *      class="btn-confirm"
 *      data-method="delete"
 *      data-title="{{ $user->getName() }}"
 * ></a>
 */
export class ConfirmBtn {
    constructor() {
        this.btn = document.querySelectorAll('.btn-confirm');

        if (! this.validate()) {
            return;
        }

        this.action()
    }

    validate() {
        return this.btn.length > 0;
    }

    getCsrfToken() {
        let csrfTag = document.querySelector('meta[name=csrf]');
        if (! csrfTag) {
            throw new Element('CSRF tag not found');
        }

        return csrfTag.getAttribute('content');
    }

    action() {
        let self = this

        this.btn.forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                let href = this.getAttribute('href')
                let {method, title} = this.dataset;

                if (confirm(`Вы хотите удалить ${title}`)) {
                    self.createFormElement(href, method).submit();
                }
            });
        })
    }

    createFormElement(href, method) {
        return $('<form action="' + href + '" method="POST">' +
            '<input type="hidden" name="_token" value="' + this.getCsrfToken() + '">' +
            '<input type="hidden" name="_method" value="' + method + '">' +
            '</form>')
            .appendTo($(document.body))
    }
}
