<div class="panel panel-default">
    <div class="panel-heading" onClick="collapse('preferencesTable');">
        Preferences
    </div>
    <table class="table table-hover preferencesTable" style="display: none;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Options</th>
            <th>Default</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($preferences as $preference)
        <tr>
            <td>{{ $preference->name }}</td>
            <td>{{ $preference->value }}</td>
            <td>{{ $preference->default }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if ($preferences->getTotal() > $preferences->getPerPage())
        <div class="panel-footer preferencesTable" style="display: none;">
            {{ $preferences->links() }}
        </div>
    @endif
</div>