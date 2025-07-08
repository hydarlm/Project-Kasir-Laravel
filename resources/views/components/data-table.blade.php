<div>
    <?php
    ?>
    @props(['headers' => []])

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-3">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
