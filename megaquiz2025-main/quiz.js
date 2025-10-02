const quizId = new URLSearchParams(window.location.search).get('id');

fetch('wczytaj_quiz.php?id=' + quizId)
.then(res => res.json())
.then(data => {
    if(data.error) { document.getElementById('quiz-container').innerText = data.error; return; }

    document.getElementById('quiz-title').innerText = data.quiz.nazwa;
    const container = document.getElementById('quiz-container');

    data.pytania.forEach((p, i) => {
        const div = document.createElement('div');
        div.innerHTML = `<h3>${i+1}. ${p.tresc}</h3>`;
        if(p.typ === 'abcd') {
            p.odpowiedzi.forEach(o => {
                div.innerHTML += `<label><input type="radio" name="q${p.id}" value="${o.id}"> ${o.tresc}</label><br>`;
            });
        } else {
            div.innerHTML += `<input type="text" name="q${p.id}" placeholder="Twoja odpowiedź"><br>`;
        }
        container.appendChild(div);
    });

    document.getElementById('submit-btn').style.display = 'block';
});

document.getElementById('submit-btn').addEventListener('click', () => {
    const answers = {};
    document.querySelectorAll('input').forEach(input => {
        if(input.checked || input.type === 'text') {
            answers[input.name] = input.value;
        }
    });
    fetch('save_wynik.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({quiz_id: quizId, odp: answers})
    })
    .then(res => res.json())
    .then(resp => alert('Wynik zapisany: '+JSON.stringify(resp)));
});
