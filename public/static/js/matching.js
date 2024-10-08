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
            submitAnswers();
        }
    }

    // 回答ボタンのクリックイベント
    $('.answer-btn').click(function() {
        var answer = $(this).data('answer');
        answers.push({
            question: questions[currentQuestionIndex].genre_name,
            answer: answer
        });

        currentQuestionIndex++;

        updateQuestion();
    });

    // 回答をサーバーに送信する関数
    function submitAnswers() {
        $.ajax({
            url: '/api/submit-answers',
            type: 'POST',
            data: {
                answers: answers
            },
            success: function(response) {
                alert('回答が送信されました');
            },
            error: function(error) {
                console.error('送信エラー', error);
            }
        });
    }

    // 初期化 - 最初の質問を表示
    updateQuestion();
});
