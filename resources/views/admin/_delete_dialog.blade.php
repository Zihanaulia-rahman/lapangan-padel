<dialog id="delete-court-dialog" class="club-dialog" closedby="any" aria-labelledby="delete-dialog-title">
    <div class="p-6 sm:p-7 space-y-5">
        <div class="space-y-2">
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-red-300">Konfirmasi Penghapusan</span>
            <h2 id="delete-dialog-title" class="text-xl font-bold text-white">Hapus Lapangan?</h2>
            <p class="text-sm text-[#93ABA6] leading-relaxed">
                Anda akan menghapus <strong id="delete-court-name" class="text-white">lapangan ini</strong> beserta riwayat detail booking yang terhubung. Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>

        <div class="flex flex-wrap items-center justify-end gap-3 pt-2 border-t border-white/10">
            <form method="dialog">
                <button
                    type="submit"
                    value="cancel"
                    autofocus
                    class="px-5 py-2.5 rounded-full border border-white/20 hover:border-white/50 text-xs font-semibold text-white transition cursor-pointer"
                >
                    Batal
                </button>
            </form>

            <form id="delete-court-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-full bg-red-500 hover:bg-red-400 text-white text-xs font-bold transition cursor-pointer"
                >
                    Ya, Hapus Arena
                </button>
            </form>
        </div>
    </div>
</dialog>
