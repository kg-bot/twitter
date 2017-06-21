{% if posts %}
    {% for post in posts %}
        <div class="panel panel-default" data-id={{ post.getId() }}>
            <div class="panel-body">
                {{ post.getPost() }}
                {% if post.getEmail() == session.get('email') or session.get('role') == 'admin' %}
                    <div class="text-center">
                        <a class="btn btn-danger" href="#" role="button">Delete</a>
                    </div>
                {% endif %}
            </div>
        </div>
    {% endfor %}
{% endif %}