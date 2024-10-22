$(document).ready(function() {
    // hidden inputからジャンルデータを取得し、JavaScriptのオブジェクトにパース
    var genreData = $('#genre-data').val();
    try {
        var questions = JSON.parse(genreData);
    } catch (error) {
        console.error("JSONのパースに失敗しました:", error);
    }

    var currentQuestionIndex = 0;
    var answers = [];

    // 質問を更新する関数
    function updateQuestion() {
        if (currentQuestionIndex < questions.length) {
            $('#question-text').text(questions[currentQuestionIndex].genre_name); // ジャンル名を表示
        } else {
            // 全ての質問が終わったら回答をサーバーに送信
            $('#question-container').addClass('hidden');
            $('#view-matching-video').removeClass('hidden');

            // 回答をhidden inputにJSON形式で格納
            $('#selectGenre').val(JSON.stringify(answers));
        }
    }

    // 回答ボタンのクリックイベント
    $('.answer-btn').click(function() {
        var answer = $(this).data('answer');
        answers.push({
            question: questions[currentQuestionIndex].genre_id,
            genre_name: questions[currentQuestionIndex].genre_name,
            answer: answer
        });
        currentQuestionIndex++;

        updateQuestion();
    });

    // 初期化 - 最初の質問を表示
    updateQuestion();
});
