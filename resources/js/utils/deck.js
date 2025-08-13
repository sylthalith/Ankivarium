import playIcon from "../../images/Play.svg";
import plusIcon from "../../images/Plus.svg";
import editIcon from "../../images/EditOutlined.svg";
import deleteIcon from "../../images/DeleteOutlined.svg";

export function deckHTML() {
    return `
        <div class="deck-title">
            <h3></h3>
        </div>
        <div class="to-study">
            0 карточек
        </div>
        <div class="progress-bar">
            <progress max="0" value="0"></progress>
        </div>
        <div class="progress">
            Изучено: 0/0 (0%)
        </div>
        <div class="actions">
            <button class="btn action-btn study-btn">
                <img src="${playIcon}">
                Учить
            </button>
            <button class="btn action-btn add-btn">
                <img src="${plusIcon}">
                Добавить
            </button>
            <button class="btn action-btn edit-btn">
                <img src="${editIcon}">
                Изменить
            </button>
            <button class="btn action-btn delete-btn">
                <img src="${deleteIcon}">
                Удалить
            </button>
        </div>
    `
}
