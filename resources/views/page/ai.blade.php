<x-layouts.app>
    <div class="flex flex-col h-[calc(100vh-4rem)] max-w-3xl mx-auto p-4">
        <h1 class="text-xl font-semibold text-base-content mb-4">AI Assistant</h1>

        <div id="ai-messages" class="flex-1 overflow-y-auto space-y-4 pr-2 mb-4">
            <div class="chat chat-start">
                <div class="chat-bubble chat-bubble-neutral">
                    Halo, tanya apa aja soal data trading lo.
                </div>
            </div>
        </div>

        <form id="ai-form" class="flex gap-2">
            <input type="text" id="ai-input" placeholder="Ketik pesan..."
                class="input input-bordered flex-1 bg-base-200" autocomplete="off" />
            <button type="submit" id="ai-submit" class="btn btn-primary">
                Kirim
            </button>
        </form>
    </div>

    @push('scripts')
        <script>
            (function() {
                function initAiPage() {
                    const form = document.getElementById('ai-form');
                    const input = document.getElementById('ai-input');
                    const messages = document.getElementById('ai-messages');
                    const submitBtn = document.getElementById('ai-submit');

                    if (!form || form.dataset.bound === 'true') return;
                    form.dataset.bound = 'true';

                    function appendBubble(role, text) {
                        const wrap = document.createElement('div');
                        wrap.className = 'chat ' + (role === 'user' ? 'chat-end' : 'chat-start');

                        const bubble = document.createElement('div');
                        bubble.className = 'chat-bubble ' + (role === 'user' ? 'chat-bubble-primary' :
                            'chat-bubble-neutral');
                        bubble.textContent = text;

                        wrap.appendChild(bubble);
                        messages.appendChild(wrap);
                        messages.scrollTop = messages.scrollHeight;
                        return bubble;
                    }

                    async function handleSubmit(e) {
                        e.preventDefault();
                        const message = input.value.trim();
                        if (!message) return;

                        appendBubble('user', message);
                        input.value = '';
                        submitBtn.disabled = true;

                        const aiBubble = appendBubble('ai', '');
                        let fullText = '';

                        try {
                            const res = await fetch('/api/ai/ask', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    message
                                }),
                            });

                            const reader = res.body.getReader();
                            const decoder = new TextDecoder();
                            let buffer = '';

                            while (true) {
                                const {
                                    done,
                                    value
                                } = await reader.read();
                                if (done) break;

                                buffer += decoder.decode(value, {
                                    stream: true
                                });
                                const parts = buffer.split('\n\n');
                                buffer = parts.pop();

                                for (const part of parts) {
                                    if (!part.startsWith('data: ')) continue;
                                    const data = part.slice(6).trim();
                                    if (data === '[DONE]') continue;

                                    try {
                                        const parsed = JSON.parse(data);
                                        if (parsed.content) {
                                            fullText += parsed.content;
                                            aiBubble.textContent = fullText;
                                            messages.scrollTop = messages.scrollHeight;
                                        }
                                    } catch (err) {
                                        // skip malformed chunk
                                    }
                                }
                            }
                        } catch (err) {
                            aiBubble.textContent = 'Error: gagal konek ke AI.';
                        } finally {
                            submitBtn.disabled = false;
                        }
                    }

                    form.addEventListener('submit', handleSubmit);
                }

                document.addEventListener('turbo:load', initAiPage);
                document.addEventListener('DOMContentLoaded', initAiPage);
            })();
        </script>
    @endpush
</x-layouts.app>
