<x-admin-layout> 
       <section class="bg-white p-12 antialiased md:p-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Customers</h2>
                {{-- <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Add New Customer</button> --}}
            </div>

            <div class="mb-4">
                {{-- <input type="text" placeholder="Search Customers" class="border rounded-lg px-4 py-2 w-1/3" /> --}}
            </div>

            <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200">
                                <input type="checkbox">
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200">Name</th>
                            <th class="px-6 py-3 border-b border-gray-200">Email</th>
                            <th class="px-6 py-3 border-b border-gray-200">Purchase Date</th>
                            <th class="px-6 py-3 border-b border-gray-200">Phone</th>
                            <th class="px-6 py-3 border-b border-gray-200">Spent</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr class="border-b border-gray-200  hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox">
                                </td>
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <img src="{{ $customer->avatar }}" alt="Customer" class="h-8 w-8 rounded-full">
                                    <span class="font-medium">{{ $customer->name }}</span>
                                </td>
                                <td class="px-6 py-4">{{ $customer->email }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($customer->purchase_date)->format('d M, Y \a\t g:ia') }}</td>
                                <td class="px-6 py-4">{{ $customer->phone ?? '-' }}</td>
                                <td class="px-6 py-4 font-medium">${{ number_format($customer->spent, 2) }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-admin-layout>
