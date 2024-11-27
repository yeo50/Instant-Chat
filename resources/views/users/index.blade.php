<x-app-layout>
    <section class="p-4">


        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-start">No.</th>
                    <th class="text-start">User Name</th>
                    <th class="text-start">User Email</th>
                    <th class="text-start">User Photo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td class="text-start">{{ $key + 1 }}</td>
                        <td class="text-start">{{ $user->name }}</td>
                        <td class="text-start">{{ $user->email }}</td>

                        <td class="text-start">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                class="block w-20 h-20">
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </section>
</x-app-layout>
