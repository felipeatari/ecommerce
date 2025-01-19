<div>
    {{ json_encode($admin) }}
    <div class="flex flex-col">
        <span>ID: {{ $admin->id }}</span>
        <span>Nome: {{ $admin->name }}</span>
    </div>
</div>
