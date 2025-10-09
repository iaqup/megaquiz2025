const quizId = new URLSearchParams(window.location.search).get('id');

if (!quizId) {
    document.getElementById('quiz-title').innerText = "Nie podano ID quizu!";
} else {
    fetch("wczytaj_quiz.php?id=" + quizId)
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            document.getElementById('quiz-title').innerText = "Błąd: " + data.error;
            return;
        }

        document.getElementById('quiz-title').innerText = data.quiz.nazwa;

        const container = document.getElementById('quiz-container');

        data.pytania.forEach((pytanie, i) => {
            const div = document.createElement('div');
            div.className = "pytanie";

            div.innerHTML = `<h3>${i + 1}. ${pytanie.tresc}</h3>`;

            if (pytanie.typ === "abcd") {
                pytanie.odpowiedzi.forEach(o => {
                    div.innerHTML += `
                        <label>
                            <input type="radio" name="q${pytanie.id}" value="${o.id}"> ${o.tresc}
                        </label>
                    `;
                });
            } else {
                div.innerHTML += `
                    <input type="text" name="q${pytanie.id}" placeholder="Twoja odpowiedź">
                `;
            }

            container.appendChild(div);
        });

        document.getElementById('submit-btn').style.display = "block";
    })
    .catch(err => {
        document.getElementById('quiz-title').innerText = "Błąd wczytywania quizu!";
        console.error(err);
    });
}

document.getElementById('submit-btn').addEventListener('click', function() {
    const odpowiedzi = {};

    document.querySelectorAll('input').forEach(input => {
        if (input.type === "radio" && input.checked) {
            odpowiedzi[input.name] = input.value;
        } else if (input.type === "text") {
            odpowiedzi[input.name] = input.value.trim();
        }
    });

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "wynik.php";

    const inputQuiz = document.createElement("input");
    inputQuiz.type = "hidden";
    inputQuiz.name = "quiz_id";
    inputQuiz.value = quizId;
    form.appendChild(inputQuiz);

    for (const key in odpowiedzi) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = `odp[${key.replace("q","")}]`;
        input.value = odpowiedzi[key];
        form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
});
