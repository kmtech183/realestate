<x-app-layout>
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span
                    class="text-xs font-bold uppercase text-emerald-600 tracking-wider">Lead
                    Management</span>
                <h1
                    class="text-3xl font-black text-slate-900 mt-1">
                    Client Inquiries</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Prospective buyers interested in your
                    real estate listings.</p>
            </div>
        </div>

        @if ($inquiries->isEmpty())
            <div
                class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm">
                <p class="text-slate-500 text-sm">No
                    inquiries received yet.</p>
            </div>
        @else
            <div
                class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table
                        class="w-full text-left text-xs text-slate-600">
                        <thead
                            class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                            <tr>
                                <th class="p-4">Property
                                </th>
                                <th class="p-4">Client
                                </th>
                                <th class="p-4">Contact
                                </th>
                                <th class="p-4">Message
                                </th>
                                <th class="p-4">Status
                                </th>
                                <th class="p-4">Date</th>
                                <th class="p-4 text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-slate-100">
                            @foreach ($inquiries as $inquiry)
                                <tr
                                    class="hover:bg-slate-50 transition">
                                    <td
                                        class="p-4 font-bold text-slate-900">
                                        <a href="{{ route('properties.show', $inquiry->property->slug) }}"
                                            class="hover:text-emerald-600">
                                            {{ $inquiry->property->title }}
                                        </a>
                                    </td>
                                    <td
                                        class="p-4 font-semibold text-slate-800">
                                        {{ $inquiry->name }}
                                    </td>
                                    <td class="p-4">
                                        <div>📧
                                            {{ $inquiry->email }}
                                        </div>
                                        <div
                                            class="text-emerald-600 font-semibold mt-0.5">
                                            📞
                                            {{ $inquiry->phone }}
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 max-w-xs truncate text-slate-500">
                                        {{ $inquiry->message }}
                                    </td>
                                    <td class="p-4">
                                        <span
                                            class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px] {{ $inquiry->status === 'new' ? 'bg-amber-100 text-amber-800' : ($inquiry->status === 'contacted' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-800') }}">
                                            {{ $inquiry->status }}
                                        </span>
                                    </td>
                                    <td
                                        class="p-4 text-slate-400">
                                        {{ $inquiry->created_at->format('d M Y, h:i A') }}
                                    </td>
                                    <td
                                        class="p-4 text-right">
                                        <form
                                            action="{{ route('agent.inquiries.update-status', $inquiry->id) }}"
                                            method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input
                                                type="hidden"
                                                name="status"
                                                value="contacted">
                                            <button
                                                type="submit"
                                                class="px-3 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold rounded-lg text-xs transition">
                                                Mark
                                                Contacted
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
