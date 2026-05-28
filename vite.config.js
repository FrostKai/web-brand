import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

import { createClient } from '@supabase/supabase-js'

const supabaseUrl = 'https://vlxtnalwlytxvxbgtmqg.supabase.co/rest/v1/' // Ganti pake URL-mu
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZseHRuYWx3bHl0eHZ4Ymd0bXFnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3Nzk4NjQ5NTYsImV4cCI6MjA5NTQ0MDk1Nn0.aYcnFN59zCYJnREnc7yzHsOIwtt0KfQp7VfSuxpQhao'
export const supabase = createClient(supabaseUrl, supabaseKey)
// Fungsi kirim email reset
const { data, error } = await supabase.auth.resetPasswordForEmail('email_user_yang_lupa@gmail.com', {
    redirectTo: 'http://localhost:5173/update-password', // Harus persis sama dengan yang didaftarkan tadi
})
// Fungsi update password ke database
const { data, error } = await supabase.auth.updateUser({
    password: 'password_baru_yang_diketik_user'
})

if (!error) {
    alert("Password berhasil diganti! Silakan login kembali.")
    // Arahkan ke halaman login utama
}