
import { useEffect, useState } from "react";
import "./App.css";

const API_URL = "http://127.0.0.1:8000/api";

function App() {
  const [criteres, setCriteres] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  const [showForm, setShowForm] = useState(false);
  const [editingId, setEditingId] = useState(null);

  const [formData, setFormData] = useState({
    nom: "",
    description: "",
    bareme: 20,
    coefficient: 1,
  });

  // =========================
  // RÉCUPÉRER LES CRITÈRES
  // =========================

  const fetchCriteres = async () => {
    try {
      setLoading(true);
      setError("");

      // Pas de backticks ici
      const response = await fetch(API_URL + "/criteres");

      if (!response.ok) {
        throw new Error("Erreur lors de la récupération des critères.");
      }

      const data = await response.json();

      const criteresFormates = data.map(function (critere) {
        return {
          id: critere.idCritere,
          nom: critere.libelle,
          description: critere.description,
          bareme: critere.bareme !== undefined ? critere.bareme : 20,
          coefficient:
            critere.coefficient !== undefined
              ? critere.coefficient
              : 1,
        };
      });

      setCriteres(criteresFormates);
    } catch (err) {
      console.error("Erreur API :", err);

      setError(
        "Impossible de récupérer les critères depuis le serveur Laravel."
      );
    } finally {
      setLoading(false);
    }
  };

  // =========================
  // CHARGEMENT AU DÉMARRAGE
  // =========================

  useEffect(function () {
    fetchCriteres();
  }, []);

  // =========================
  // CHANGEMENT DU FORMULAIRE
  // =========================

  const handleChange = (e) => {
    const name = e.target.name;
    const value = e.target.value;

    setFormData({
      ...formData,
      [name]: value,
    });
  };

  // =========================
  // AJOUT / MODIFICATION
  // =========================

  const handleSubmit = (e) => {
    e.preventDefault();

    if (editingId !== null) {
      setCriteres(
        criteres.map(function (critere) {
          if (critere.id === editingId) {
            return {
              ...critere,
              nom: formData.nom,
              description: formData.description,
              bareme: Number(formData.bareme),
              coefficient: Number(formData.coefficient),
            };
          }

          return critere;
        })
      );
    } else {
      const nouveauCritere = {
        id: Date.now(),
        nom: formData.nom,
        description: formData.description,
        bareme: Number(formData.bareme),
        coefficient: Number(formData.coefficient),
      };

      setCriteres([...criteres, nouveauCritere]);
    }

    resetForm();
  };

  // =========================
  // MODIFIER
  // =========================

  const handleEdit = (critere) => {
    setEditingId(critere.id);

    setFormData({
      nom: critere.nom,
      description: critere.description,
      bareme: critere.bareme,
      coefficient: critere.coefficient,
    });

    setShowForm(true);
  };

  // =========================
  // SUPPRIMER
  // =========================

  const handleDelete = (id) => {
    setCriteres(
      criteres.filter(function (critere) {
        return critere.id !== id;
      })
    );
  };

  // =========================
  // RÉINITIALISER
  // =========================

  const resetForm = () => {
    setFormData({
      nom: "",
      description: "",
      bareme: 20,
      coefficient: 1,
    });

    setEditingId(null);
    setShowForm(false);
  };

  // =========================
  // AFFICHAGE
  // =========================

  return (
    <div className="app">

      {/* HEADER */}

      <header className="header">
        <div>
          <h1>Gestion des critères</h1>
          <p>Évaluation des soutenances de Master</p>
        </div>

        <button
          className="btn-primary"
          onClick={() => {
            resetForm();
            setShowForm(true);
          }}
        >
          + Ajouter un critère
        </button>
      </header>

      {/* CONTENU */}

      <main className="content">

        {/* CARTES INFORMATIONS */}

        <section className="info-cards">

          <div className="info-card">
            <span>Critères</span>
            <strong>{criteres.length}</strong>
          </div>

          <div className="info-card">
            <span>Barème</span>
            <strong>20</strong>
          </div>

          <div className="info-card">
            <span>Type d'évaluation</span>
            <strong>Master</strong>
          </div>

        </section>

        {/* CHARGEMENT */}

        {loading && (
          <p>Chargement des critères...</p>
        )}

        {/* ERREUR */}

        {error && (
          <p>{error}</p>
        )}

        {/* FORMULAIRE */}

        {showForm && (
          <section className="form-section">

            <h2>
              {editingId !== null
                ? "Modifier le critère"
                : "Ajouter un critère"}
            </h2>

            <form onSubmit={handleSubmit}>

              {/* NOM */}

              <div className="form-group">
                <label>Nom du critère</label>

                <input
                  type="text"
                  name="nom"
                  value={formData.nom}
                  onChange={handleChange}
                  placeholder="Ex : Maîtrise du sujet"
                  required
                />
              </div>

              {/* DESCRIPTION */}

              <div className="form-group">
                <label>Description</label>

                <textarea
                  name="description"
                  value={formData.description}
                  onChange={handleChange}
                  placeholder="Description du critère"
                  required
                />
              </div>

              {/* BARÈME ET COEFFICIENT */}

              <div className="form-row">

                <div className="form-group">
                  <label>Barème</label>

                  <input
                    type="number"
                    name="bareme"
                    value={formData.bareme}
                    onChange={handleChange}
                    min="1"
                    max="100"
                    required
                  />
                </div>

                <div className="form-group">
                  <label>Coefficient</label>

                  <input
                    type="number"
                    name="coefficient"
                    value={formData.coefficient}
                    onChange={handleChange}
                    min="1"
                    required
                  />
                </div>

              </div>

              {/* BOUTONS */}

              <div className="form-actions">

                <button
                  type="button"
                  className="btn-secondary"
                  onClick={resetForm}
                >
                  Annuler
                </button>

                <button
                  type="submit"
                  className="btn-primary"
                >
                  {editingId !== null
                    ? "Enregistrer les modifications"
                    : "Enregistrer"}
                </button>

              </div>

            </form>

          </section>
        )}

        {/* TABLEAU */}

        {!loading && !error && (
          <section className="table-section">

            <div className="section-title">

              <div>
                <h2>Liste des critères</h2>

                <p>
                  Critères utilisés pour l'évaluation des soutenances
                </p>
              </div>

            </div>

            <div className="table-container">

              <table>

                <thead>
                  <tr>
                    <th>#</th>
                    <th>Critère</th>
                    <th>Description</th>
                    <th>Barème</th>
                    <th>Coefficient</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>

                  {criteres.map(function (critere) {
                    return (
                      <tr key={critere.id}>

                        <td>{critere.id}</td>

                        <td>
                          <strong>{critere.nom}</strong>
                        </td>

                        <td>
                          {critere.description}
                        </td>

                        <td>
                          {critere.bareme}
                        </td>

                        <td>
                          {critere.coefficient}
                        </td>

                        <td>

                          <div className="actions">

                            <button
                              className="btn-edit"
                              onClick={() => handleEdit(critere)}
                            >
                              Modifier
                            </button>

                            <button
                              className="btn-delete"
                              onClick={() =>
                                handleDelete(critere.id)
                              }
                            >
                              Supprimer
                            </button>

                          </div>

                        </td>

                      </tr>
                    );
                  })}

                </tbody>

              </table>

            </div>

          </section>
        )}

      </main>

    </div>
  );
}

export default App;