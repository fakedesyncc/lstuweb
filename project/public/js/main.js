let audioContext = null;
let audioBuffer = null;
let isAudioLoaded = false;

function initAudio() {
    try {
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        loadAudio();
    } catch (e) {
    }
}

function loadAudio() {
    const audioUrl = '/audio/mozhno-a-zachem.mp3';
    fetch(audioUrl, {
        method: 'GET',
        headers: {
            'Accept': 'audio/mpeg, audio/*'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.arrayBuffer();
        })
        .then(data => {
            if (audioContext && data.byteLength > 0) {
                audioContext.decodeAudioData(data)
                    .then(buffer => {
                        audioBuffer = buffer;
                        isAudioLoaded = true;
                    })
                    .catch(e => {
                        isAudioLoaded = false;
                    });
            }
        })
        .catch(e => {
            isAudioLoaded = false;
        });
}

function playSound() {
    if (!isAudioLoaded || !audioContext || !audioBuffer) {
        return;
    }

    try {
        if (audioContext.state === 'suspended') {
            audioContext.resume();
        }

        const source = audioContext.createBufferSource();
        source.buffer = audioBuffer;
        source.connect(audioContext.destination);
        source.start(0);
    } catch (e) {
    }
}

let audioElement = null;

function initAudioElement() {
    try {
        audioElement = new Audio();
        audioElement.src = '/audio/mozhno-a-zachem.mp3';
        audioElement.preload = 'auto';
        audioElement.volume = 0.8;
        
        audioElement.addEventListener('error', function(e) {
            audioElement = null;
        });
        
        audioElement.load();
    } catch (e) {
        audioElement = null;
    }
}

function playAudio() {
    if (!audioElement) {
        initAudioElement();
    }
    
    if (audioElement) {
        try {
            audioElement.currentTime = 0;
            const playPromise = audioElement.play();
            
            if (playPromise !== undefined) {
                playPromise
                    .then(() => {})
                    .catch(error => {
                        initAudioElement();
                    });
            }
        } catch (e) {
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initAudioElement();
    initAudio();

    const buttons = document.querySelectorAll('.btn, button, a.btn, input[type="submit"], .section-card, .stat-card');
    
    buttons.forEach(button => {
        if (button.tagName === 'A' && !button.href && !button.getAttribute('href')) {
            return;
        }

        button.addEventListener('click', function(e) {
            const isNavLink = this.closest('header') || this.closest('.nav-links') || this.closest('nav');
            if (!isNavLink && audioElement) {
                try {
                    audioElement.currentTime = 0;
                    const playPromise = audioElement.play();
                    if (playPromise !== undefined) {
                        playPromise.catch(() => {});
                    }
                } catch (e) {
                }
            }
        });

        button.addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.95)';
        });

        button.addEventListener('mouseup', function() {
            this.style.transform = '';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });

    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });

    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent || submitBtn.value;
                submitBtn.innerHTML = '<span class="loading"></span> Отправка...';
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    if (submitBtn.tagName === 'BUTTON') {
                        submitBtn.textContent = originalText;
                    } else {
                        submitBtn.value = originalText;
                    }
                }, 5000);
            }
        });
    });

    const searchInputs = document.querySelectorAll('input[type="text"][name*="search"], input[name="brand"], input[name="model"]');
    searchInputs.forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    const form = this.closest('form');
                    if (form && form.method === 'get') {
                        form.submit();
                    }
                }
            }, 500);
        });
    });

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                playAudio();
            }
        });
    });
});

function confirmDelete(message) {
    return confirm(message || 'Вы уверены, что хотите удалить этот элемент?');
}

function showLoading(element) {
    const originalContent = element.innerHTML;
    element.disabled = true;
    element.innerHTML = '<span class="loading"></span> Загрузка...';
    return () => {
        element.disabled = false;
        element.innerHTML = originalContent;
    };
}
